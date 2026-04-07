<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Menampilkan halaman daftar menu
     * Perbaikan: Menambahkan fungsi yang hilang untuk menangani route /menu
     */
    public function menu()
    {
        $menus = Menu::all();
        return view('menu', compact('menus'));
    }

    /**
     * Menambahkan item ke keranjang belanja (Session)
     */
    public function addToCart($id)
    {
        $menu = Menu::find($id);
        
        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan!'
            ], 404);
        }

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "nama_menu" => $menu->nama_menu,
                "quantity" => 1,
                "harga" => $menu->harga
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil ditambahkan ke keranjang!',
            'cart_count' => count(session('cart'))
        ]);
    }

    /**
     * Menampilkan halaman keranjang belanja
     */
    public function showCart()
    {
        $cartItems = session()->get('cart', []);
        $total_harga = 0;
        foreach($cartItems as $item) {
            $total_harga += (int)$item['harga'] * (int)$item['quantity'];
        }

        $semuaMeja = ['Meja 01', 'Meja 02', 'Meja 03', 'Meja 04', 'Meja 05', 'Meja 06', 'Meja 07', 'Meja 08', 'Meja 09', 'Meja 10'];
        
        // Logika meja otomatis: hanya mengambil meja yang belum diproses
        $mejaTerpakai = Order::whereIn('status', ['diproses'])->pluck('nomor_meja')->toArray();
        $mejaKosong = array_diff($semuaMeja, $mejaTerpakai);
        $mejaOtomatis = !empty($mejaKosong) ? reset($mejaKosong) : 'Penuh';

        return view('cart', compact('cartItems', 'total_harga', 'mejaOtomatis'));
    }

    /**
     * Menyimpan booking ke database
     */
    public function simpan(Request $request)
    {
        $request->validate([
            'nama_pemesan'    => 'required|string|max:255',
            'nomor_meja'      => 'required',
            'metode_pembayaran' => 'required',
            'tanggal_booking' => 'required|date',
            'jam_booking'     => 'required',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong!');
        }

        // Hitung total harga ulang di server untuk keamanan
        $total_harga = 0;
        foreach($cart as $item) {
            $total_harga += (int)$item['harga'] * (int)$item['quantity'];
        }

        /** @var User $user */
        $user = Auth::user();
        $userId = $user ? $user->id : 1; 

        $newOrder = Order::create([
            'user_id'           => $userId, 
            'nama_pembeli'      => $request->nama_pemesan,
            'nomor_meja'        => $request->nomor_meja,
            'item_pesanan'      => $cart,
            'total_harga'       => $total_harga,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status'            => 'diproses',
            'tanggal_booking'   => $request->tanggal_booking, 
            'jam_booking'       => $request->jam_booking,     
]);
    session()->forget('cart');
    return redirect()->route('order.payment', ['id' => $newOrder->id]);
    }

    /**
 * Menampilkan halaman instruksi pembayaran
 */
    public function showPayment($id)
    {
        $order = Order::findOrFail($id);
        return view('payment', compact('order'));
    }

    public function confirmPayment(Request $request, $id)
    {
        // Cari data order
        $order = Order::findOrFail($id);
        // Update status menjadi 'sukses' atau sesuai logika bisnismu
        $order->update([
            'status' => 'sukses'
            ]);

    // Redirect ke halaman history atau invoice dengan pesan sukses
        return redirect()->route('order.history')->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    /**
 * Menampilkan riwayat pesanan pelanggan yang sedang login
 */
    public function history()
    {
        // Mengambil semua pesanan milik pelanggan yang sedang login
            $orders = Order::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('history', compact('orders'));
    }
}