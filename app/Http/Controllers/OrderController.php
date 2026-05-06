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
    $orders = \App\Models\Order::where('user_id', auth()->id())
                ->latest()
                ->get();

    return view('history', compact('orders'));
}
public function showCart()
{
    // Logika untuk mengambil data keranjang (misalnya dari session atau database)
    // Contoh sederhana:
    $cartItems = session()->get('cart', []);

    return view('cart', compact('cartItems'));
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
        'metode_pembayaran' => 'required', // Tambahkan validasi ini
    ]);

    $cart = session()->get('cart');
    if (!$cart) return redirect()->back()->with('error', 'Keranjang kosong!');

    $order = \App\Models\Order::create([
        'nomor_pesanan' => 'VAL-' . strtoupper(uniqid()),
        'user_id'       => auth()->id(),
        'nama_pemesan'  => $request->nama_pemesan,
        'nomor_wa'      => $request->nomor_wa,
        'jenis_pesanan' => $request->jenis_pesanan,
        'metode_pembayaran' => $request->metode_pembayaran, // Tambahkan baris ini
        'alamat'        => $request->alamat ?? '-',
        'nomor_meja'    => $request->nomor_meja ?? '-',
        'item_pesanan'  => json_encode($cart),
        'total_bayar'   => collect($cart)->sum(fn($item) => $item['harga'] * $item['quantity']),
        'status'        => 'pending'
    ]);

    session()->forget('cart');
    return redirect()->route('invoice.show', $order->id);
}
}