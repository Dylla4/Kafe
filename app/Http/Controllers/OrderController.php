<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Menghilangkan warning Intelephense dengan memberi argumen kolom
        $orders = Order::latest('created_at')->get();
        return view('admin.dashboard', compact('orders'));
    }

    public function menu()
    {
        // 1. Ambil semua data dari tabel menus di database
        $menus = Menu::all(); 

        // 2. Kirim variabel $menus ke halaman view 'menu'
        return view('menu', compact('menus'));
    }

    public function simpan(Request $request)
    {
        // 1. Validasi Input sesuai dengan kolom di Model
        $validated = $request->validate([
            'nama_pemesan'      => 'required|string|max:255',
            'nomor_wa'          => 'required|string|min:10',
            'jenis_pesanan'     => 'required|in:dine_in,delivery,take_away',
            'metode_pembayaran' => 'required|string',
            'tanggal_booking'   => 'required|date|after_or_equal:today',
            'jam_booking'       => 'required',
            'nomor_meja'        => 'nullable|string',
            'alamat'            => 'nullable|string',
            'catatan'           => 'nullable|string',
            'item_pesanan'      => 'required|array', // Pastikan input berupa array
            'total_bayar'       => 'required|numeric',
        ]);

        try {
            // 2. Tambahkan data otomatis yang tidak ada di form
            $validated['user_id'] = Auth::id();
            $validated['nomor_pesanan'] = 'ORD-' . strtoupper(uniqid());
            $validated['status'] = 'pending';

            // 3. Simpan ke Database
            Order::create($validated);

            return redirect()->back()->with('success', 'Pesanan berhasil dibuat! Nomor Pesanan: ' . $validated['nomor_pesanan']);
            
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function indexAdmin() 
{
    // Mengambil data ulasan dari model Ulasan
    $ulasans = \App\Models\Ulasan::latest()->get(); 
    return view('admin.ulasan', compact('ulasans'));
}
public function history()
{
    // Mengambil pesanan milik user yang sedang login
    $orders = Order::where('user_id', Auth::id())
                ->with('ulasan') // Ini memuat relasi ulasan (HasOne) dari model Order
                ->latest()
                ->get();

    return view('history', compact('orders'));
}
public function showCart(Request $request)
    {
        $cartItems = session()->get('cart', []);
        
        $total_harga = collect($cartItems)->sum(function($item) {
            return (int)$item['harga'] * (int)$item['quantity'];
        });

        // REVISI LOGIKA: Ambil parameter tanggal dari request filter (Default hari ini jika baru buka halaman)
        $tanggalDipilih = $request->input('tanggal_pesan', date('Y-m-to')); 

        $semuaMeja = ['Meja 01', 'Meja 02', 'Meja 03', 'Meja 04', 'Meja 05', 'Meja 06', 'Meja 07', 'Meja 08', 'Meja 09', 'Meja 10'];
        
        // Meja hanya dianggap terpakai jika dipesan DI TANGGAL YANG SAMA
        $mejaTerpakai = Order::whereIn('status', ['pending', 'diproses', 'siap', 'sukses'])
                             ->whereDate('tanggal_booking', $tanggalDipilih)
                             ->whereNotNull('nomor_meja')
                             ->pluck('nomor_meja')
                             ->toArray();
                                                                     
        $mejaKosong = array_diff($semuaMeja, $mejaTerpakai);
        $mejaOtomatis = !empty($mejaKosong) ? reset($mejaKosong) : 'Penuh';

        return view('cart', compact('cartItems', 'total_harga', 'mejaOtomatis'));
    }
public function addToCart(Request $request, $id)
{
    /** @var \App\Models\Menu $menu */
    $menu = Menu::find($id);

    if (!$menu) {
        return response()->json(['error' => 'Menu tidak ditemukan.'], 404);
    }

    $cart = session()->get('cart', []);

    // Ambil kuantitas yang dikirim dari form/modal halaman menu.
    $quantityInput = (int) $request->input('quantity', 1);

    // =========================================================================
    // TANGKAP DATA KUSTOMISASI MINUMAN (Hot/Ice, Es, Gula)
    // =========================================================================
    $pilihanMenuInput = $request->input('pilihan_menu', '-');

    if ($request->has('level_es') || $request->has('level_kemanisan')) {
        $opsi = [];
        if ($request->input('pilihan_menu')) $opsi[] = $request->input('pilihan_menu');
        if ($request->input('level_es')) $opsi[] = $request->input('level_es');
        if ($request->input('level_kemanisan')) $opsi[] = $request->input('level_kemanisan');
        
        $pilihanMenuInput = implode(', ', $opsi);
    }

    // =========================================================================
    // BARU: TANGKAP DATA CATATAN / NOTE TO RESTAURANT
    // =========================================================================
    // Mengambil name="catatan" dari modal frontend (default: '-' jika kosong)
    $catatanInput = $request->input('catatan', '-');
    // =========================================================================

    // 1. Hitung total kuantitas jika item ini sudah ada di keranjang sebelumnya
    $existingQuantity = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
    $totalNextQuantity = $existingQuantity + $quantityInput;

    // 2. VALIDASI STOK
    if ($menu->stok <= 0) {
        return response()->json(['error' => 'Maaf, stok menu ini sudah habis!'], 400);
    }

    if ($totalNextQuantity > $menu->stok) {
        $sisaBisaDipesan = $menu->stok - $existingQuantity;
        if ($existingQuantity > 0) {
            return response()->json([
                'error' => "Gagal menambahkan. Di keranjang sudah ada {$existingQuantity} porsi, sisa stok hanya tinggal {$sisaBisaDipesan} porsi lagi."
            ], 400);
        }
        return response()->json(['error' => "Maaf, jumlah pesanan melebihi sisa stok yang tersedia ({$menu->stok} porsi)."], 400);
    }

    // 3. Masukkan ke dalam session keranjang beserta kustomisasi & catatannya
    if (isset($cart[$id])) {
        $cart[$id]['quantity'] += $quantityInput; 
        $cart[$id]['pilihan_menu'] = $pilihanMenuInput; 
        $cart[$id]['catatan'] = $catatanInput; // <-- BARU: Perbarui catatan jika ditambahkan lagi
    } else {
        $cart[$id] = [
            "nama_menu"    => $menu->nama_menu,
            "quantity"     => $quantityInput, 
            "harga"        => $menu->harga,
            "foto"         => $menu->foto,
            "pilihan_menu" => $pilihanMenuInput,
            "catatan"      => $catatanInput // <-- BARU: Simpan data catatan ke dalam session keranjang
        ];
    }

    session()->put('cart', $cart);

    return response()->json(['success' => 'Berhasil ditambahkan ke keranjang!']);
}
public function updateCart(Request $request, $id) {
    $cart = session()->get('cart');

    // Cek apakah item ada di keranjang
    if(isset($cart[$id])) {
        if($request->action == 'increase') {
            $cart[$id]['quantity']++;
        } else if($request->action == 'decrease') {
            $cart[$id]['quantity']--;
        }

        // Jika kuantitas 0 atau kurang, hapus dari keranjang
        if($cart[$id]['quantity'] <= 0) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);
        return response()->json(['success' => true]);
    }

    // Jika item tidak ditemukan, kirim error yang akan ditangkap JavaScript
    return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
}
public function cekMejaTersedia(Request $request)
    {
        $tanggal = $request->query('tanggal');
        $jam = $request->query('jam');

        if (!$tanggal || !$jam) {
            return response()->json(['meja' => 'Meja 01']);
        }

        // Cari meja kosong dari nomor 1 sampai 20
        for ($i = 1; $i <= 20; $i++) {
            $formatMejaCek = 'Meja ' . str_pad($i, 2, '0', STR_PAD_LEFT);

            $sudahDiBooking = Order::where('jenis_pesanan', 'dine_in')
                ->where('nomor_meja', $formatMejaCek)
                ->whereDate('tanggal_booking', $tanggal)
                ->where('jam_booking', $jam)
                ->where('status', '!=', 'batal')
                ->exists();

            // Jika meja ini kosong, langsung kembalikan ke frontend
            if (!$sudahDiBooking) {
                return response()->json(['meja' => $formatMejaCek]);
            }
        }

        // Jika looping selesai dan semua penuh
        return response()->json(['meja' => 'Maaf, Meja Penuh']);
    }

// FUNGSI CHECKOUT
public function prosesCheckout(Request $request) 
{
    $request->validate([
        'nama_pemesan' => 'required',
        'nomor_wa' => 'required',
        'jenis_pesanan' => 'required',
        'metode_pembayaran' => 'required',
        'tanggal_booking' => 'required|date',
        'jam_booking' => 'required',
    ]);

    $cart = session()->get('cart');
    if (!$cart) {
        return redirect()->back()->with('error', 'Keranjang kosong!');
    }

    // =========================================================================
    // VALIDASI STOK SEBELUM MEMBUAT PESANAN (Mencegah Over-order / Bentrok Stok)
    // =========================================================================
    foreach ($cart as $id => $details) {
        /** @var \App\Models\Menu $menu */
        $menu = Menu::find($id);
        
        // Cek jika menu tidak ditemukan atau stoknya sudah kurang dari kuantitas keranjang
        if (!$menu || $menu->stok < $details['quantity']) {
            $namaMenu = $menu ? $menu->nama_menu : 'Menu';
            $sisaStok = $menu ? $menu->stok : 0;
            
            if ($sisaStok > 0) {
                return redirect()->back()->with('error', "Maaf, stok untuk {$namaMenu} tidak mencukupi. Sisa stok saat ini tinggal {$sisaStok} porsi.");
            } else {
                return redirect()->back()->with('error', "Maaf, menu {$namaMenu} tiba-tiba saja baru saja habis dipesan pelanggan lain!");
            }
        }
    }
    // =========================================================================

    $nomorMeja = '-';
    if ($request->jenis_pesanan === 'dine_in') {
        // Jika frontend mengirimkan status penuh, blokir proses simpan
        if ($request->nomor_meja === 'Maaf, Meja Penuh' || !$request->nomor_meja) {
            return redirect()->back()->with('error', 'Maaf, seluruh meja pada jam tersebut sudah penuh!');
        }
        $nomorMeja = $request->nomor_meja;
    }

    // Tentukan status operasional pesanan dan status konfirmasi pembayaran
    if ($request->metode_pembayaran === 'cash') {
        $statusAwal = 'diproses';
        $statusBayarAwal = 'unpaid'; // Cash statusnya unpaid dulu sebelum dibayar di kasir
    } else {
        $statusAwal = 'diproses';
        $statusBayarAwal = 'paid'; // QRIS otomatis paid sejak awal checkout
    }

    // =========================================================================
    // EKSTRAK DATA DARI KERANJANG UNTUK DIKIRIM KE DATABASE
    // =========================================================================
    $semuaPilihan = [];
    $semuaCatatan = [];

    foreach ($cart as $item) {
        // 1. Ambil data pilihan menu kustomisasi
        if (!empty($item['pilihan_menu']) && $item['pilihan_menu'] !== '-') {
            $semuaPilihan[] = $item['nama_menu'] . ' (' . $item['pilihan_menu'] . ')';
        }
        
        // 2. BARU: Ambil data catatan (Note to Restaurant) dari modal
        if (!empty($item['catatan']) && $item['catatan'] !== '-') {
            $semuaCatatan[] = $item['nama_menu'] . ': ' . $item['catatan'];
        }
    }

    // Gabungkan array data dengan pembatas garis vertikal '|' jika ada banyak jenis menu
    $pilihanMenuDatabase = !empty($semuaPilihan) ? implode(' | ', $semuaPilihan) : '-';
    $catatanDatabase = !empty($semuaCatatan) ? implode(' | ', $semuaCatatan) : '-'; // <-- Hasil olahan data catatan
    // =========================================================================

    $order = Order::create([
        'nomor_pesanan' => 'VAL-' . strtoupper(uniqid()),
        'user_id' => Auth::id(),
        'nama_pemesan'  => $request->nama_pemesan,
        'nomor_wa'      => $request->nomor_wa,
        'jenis_pesanan' => $request->jenis_pesanan,
        'metode_pembayaran' => $request->metode_pembayaran,
        'alamat'        => $request->alamat ?? '-',
        'nomor_meja'    => $nomorMeja, 
        'tanggal_booking' => $request->tanggal_booking,
        'jam_booking'     => $request->jam_booking,
        'pilihan_menu'  => $pilihanMenuDatabase, 
        'catatan'       => $catatanDatabase, // <--- BARU: Menyimpan teks catatan terstruktur ke database
        'item_pesanan'  => json_encode($cart),
        'total_bayar'   => collect($cart)->sum(fn($item) => $item['harga'] * $item['quantity']),
        'status'        => $statusAwal,
        'status_pembayaran' => $statusBayarAwal 
    ]);

    // Potong stok otomatis setelah dipastikan lolos semua validasi di atas
    foreach ($cart as $id => $details) {
        /** @var \App\Models\Menu $menu */
        $menu = Menu::find($id);
        if ($menu) {
            $menu->decrement('stok', $details['quantity']);
        }
    }

    session()->forget('cart');

    if ($request->metode_pembayaran === 'cash') {
        return redirect()->route('invoice.print', $order->id)
                         ->with('success', 'Pesanan berhasil ditempatkan di ' . $nomorMeja);
    } else {
        return redirect()->route('order.payment', $order->id);
    }
}
    public function batalkanPesanan($id)
    {
        $order = Order::findOrFail($id);
        
        // Opsional: Kembalikan stok jika pesanan dibatalkan
        $items = json_decode($order->item_pesanan, true);
        foreach ($items as $idMenu => $details) {
            Menu::where('id', $idMenu)->increment('stok', $details['quantity']);
        }

        $order->delete(); // Menghapus dari database
        return redirect()->back()->with('success', 'Pesanan telah dibatalkan dan dihapus.');
    }
    public function konfirmasi(string $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'sukses']); 
        return redirect()->route('order.invoice', $order->id);
    }

    public function confirmPayment(Request $request, $id) // <-- Tambahkan Request $request di sini
{
    /** @var \App\Models\Order $order */
    $order = Order::findOrFail($id);
    
    if ($request->metode_pembayaran === 'qris') {
        $statusAwal = 'diproses';
        $statusBayarAwal = 'paid';
    } else {
        $statusAwal = 'pending';
        $statusBayarAwal = 'unpaid';
    }

    // Update status ke database
    $order->update([
        'status'            => 'diproses',
        'status_pembayaran' => 'paid'
    ]);

    return redirect()->route('invoice.print', $order->id)
                     ->with('success', 'Pembayaran berhasil dikonfirmasi!');
}
    
    public function printInvoice($id)
    {
        $order = Order::findOrFail($id);
        
        // Cek apakah item_pesanan perlu di-decode (jika di database bentuknya string JSON)
        $items = $order->item_pesanan ?? [];

        return view('invoice', compact('order', 'items'));
    }
    
    public function showPayment($id)
    {
        $order = Order::findOrFail($id);
        return view('payment', compact('order'));
    }
    
}