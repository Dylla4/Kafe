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
                ->latest()
                ->get();

    return view('history', compact('orders'));
}
public function showCart()
    {
        $cartItems = session()->get('cart', []);
        
        $total_harga = collect($cartItems)->sum(function($item) {
            return (int)$item['harga'] * (int)$item['quantity'];
        });

        $semuaMeja = ['Meja 01', 'Meja 02', 'Meja 03', 'Meja 04', 'Meja 05', 'Meja 06', 'Meja 07', 'Meja 08', 'Meja 09', 'Meja 10'];
        $mejaTerpakai = Order::whereIn('status', ['pending', 'diproses', 'siap', 'sukses'])
                             ->whereNotNull('nomor_meja')
                             ->pluck('nomor_meja')
                             ->toArray();
                                     
        $mejaKosong = array_diff($semuaMeja, $mejaTerpakai);
        $mejaOtomatis = !empty($mejaKosong) ? reset($mejaKosong) : 'Penuh';

        return view('cart', compact('cartItems', 'total_harga', 'mejaOtomatis'));
    }
public function addToCart(Request $request, $id)
{
    // Cari menu berdasarkan ID
    $menu = Menu::find($id);

    if (!$menu) {
        return response()->json(['error' => 'Menu tidak ditemukan.'], 404);
    }

    $cart = session()->get('cart', []);

    // Jika sudah ada di keranjang, tambah quantity, jika belum, buat baru
    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            "nama_menu" => $menu->nama_menu,
            "quantity" => 1,
            "harga" => $menu->harga,
            "foto" => $menu->foto
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
    public function prosesCheckout(Request $request) {
    $request->validate([
        'nama_pemesan' => 'required',
        'nomor_wa' => 'required',
        'jenis_pesanan' => 'required',
        'metode_pembayaran' => 'required',
    ]);

    $cart = session()->get('cart');
    if (!$cart) return redirect()->back()->with('error', 'Keranjang kosong!');

    // Tentukan status awal: jika cash langsung 'diproses', jika qris tetap 'pending'
    $statusAwal = ($request->metode_pembayaran === 'cash') ? 'diproses' : 'pending';

    $order = Order::create([
        'nomor_pesanan' => 'VAL-' . strtoupper(uniqid()),
        'user_id' => Auth::id(),
        'nama_pemesan'  => $request->nama_pemesan,
        'nomor_wa'      => $request->nomor_wa,
        'jenis_pesanan' => $request->jenis_pesanan,
        'metode_pembayaran' => $request->metode_pembayaran,
        'alamat'        => $request->alamat ?? '-',
        'nomor_meja'    => $request->nomor_meja ?? '-',
        'item_pesanan'  => json_encode($cart),
        'total_bayar'   => collect($cart)->sum(fn($item) => $item['harga'] * $item['quantity']),
        'status'        => $statusAwal
    ]);

    // --- AWAL LOGIKA PENGURANGAN STOK OTOMATIS ---
    foreach ($cart as $id => $details) {
        $menu = Menu::find($id);
        if ($menu) {
            // Mengurangi stok sesuai quantity yang dibeli
            $menu->decrement('stok', $details['quantity']);
        }
    }
    // --- AKHIR LOGIKA PENGURANGAN STOK OTOMATIS ---

    session()->forget('cart');

    // LOGIKA REDIRECT BERDASARKAN METODE PEMBAYARAN
    if ($request->metode_pembayaran === 'cash') {
        return redirect()->route('invoice.print', $order->id)
                         ->with('success', 'Pesanan berhasil! Silakan lakukan pembayaran di kasir.');
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
            \App\Models\Menu::where('id', $idMenu)->increment('stok', $details['quantity']);
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

    public function confirmPayment($id)
    {
        $order = Order::findOrFail($id);
        
        // Update status dari 'pending' menjadi 'diproses'
        $order->update([
            'status' => 'diproses'
        ]);

        // Redirect ke halaman invoice
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