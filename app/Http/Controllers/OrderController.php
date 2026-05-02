<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Ulasan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar menu
     */
    public function menu()
    {
        $menus = Menu::all();
        return view('menu', compact('menus'));
    }

    /**
     * Menampilkan halaman keranjang
     */
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

    /**
     * Menyimpan pesanan baru (Checkout)
     */
    public function simpan(Request $request)
    {
        $jenis = $request->jenis_pesanan;
        
        $request->validate([
            'nama_pemesan'      => 'required|string|max:255',
            'nomor_wa'          => 'required|numeric|min:10',
            'metode_pembayaran' => 'required',
            'jenis_pesanan'     => 'required|in:dine_in,delivery,take_away',
            'tanggal_booking'   => 'required|date|after_or_equal:today',
            'jam_booking'       => 'required',
        ]);

        if ($request->jam_booking < "09:00" || $request->jam_booking > "22:00") {
            return response()->json(['success' => false, 'error' => 'Jam operasional 09:00 - 22:00'], 422);
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['success' => false, 'error' => 'Keranjang Anda masih kosong!'], 400);
        }

        $total_harga = collect($cart)->sum(function($item) {
            return (int)$item['harga'] * (int)$item['quantity'];
        });

        $jumlahPesananHariIni = Order::whereDate('created_at', today())->count() + 1;
        $nomorPesanan = 'INV-' . date('Ymd') . '-' . str_pad($jumlahPesananHariIni, 3, '0', STR_PAD_LEFT);

        try {
            $user = Auth::user();

            if ($request->nomor_wa && Auth::user()->nomor_wa !== $request->nomor_wa) {
                User::where('id', Auth::id())->update(['nomor_wa' => $request->nomor_wa]);
            }

            $newOrder = Order::create([
                'user_id'           => $user->id, 
                'nomor_pesanan'     => $nomorPesanan,
                'nama_pemesan'      => $request->nama_pemesan,
                'email_pembeli'     => $user->email,
                'nomor_wa'          => $request->nomor_wa, 
                'jenis_pesanan'     => $jenis,
                'nomor_meja'        => ($request->jenis_pesanan === 'dine_in') ? $request->nomor_meja : null,
                'alamat'            => ($request->jenis_pesanan === 'delivery') ? $request->alamat : null,
                'item_pesanan'      => $cart, 
                'total_bayar'       => $total_harga,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status'            => 'diproses',
                'tanggal_booking'   => $request->tanggal_booking, 
                'jam_booking'       => $request->jam_booking,     
            ]);

            session()->forget('cart');
            return response()->json(['success' => true, 'order_id' => $newOrder->id]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }

    /**
 * Mengurangi jumlah item di keranjang
 */
public function decrease(int $id)
{
    $cart = session()->get('cart', []);

    if(isset($cart[$id])) {
        if($cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
        } else {
            unset($cart[$id]); // Jika tinggal 1, maka hapus item
        }
        session()->put('cart', $cart);
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'error' => 'Item tidak ditemukan'], 404);
}

/**
 * Menghapus item sepenuhnya dari keranjang
 */
public function remove(int $id)
{
    $cart = session()->get('cart', []);

    if(isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'error' => 'Gagal menghapus item'], 404);
}

    public function history()
    {
        $orders = Order::where('user_id', Auth::id())->with('review')->latest()->get();
        return view('history', compact('orders'));
    }

    /**
     * Konfirmasi Lunas & Redirect ke Invoice Tunggal
     */
    public function konfirmasi(string $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'sukses']); 
        return redirect()->route('order.invoice', $order->id);
    }

    /**
     * Tampilan Invoice Tunggal (Dine-in, Delivery, Take-away)
     */
    public function printInvoice(string $id)
    {
        $order = Order::findOrFail($id);
        $items = is_array($order->item_pesanan) ? $order->item_pesanan : json_decode((string)$order->item_pesanan, true);
        
        return view('invoice', compact('order', 'items'));
    }

    // Alias agar rute lama tidak error, semua diarahkan ke printInvoice
    public function receipt(string $id) { return $this->printInvoice($id); }
    public function reservation(string $id) { return $this->printInvoice($id); }

    public function showPayment(string $id)
    {
        $order = Order::findOrFail($id);
        if (in_array($order->status, ['sukses', 'lunas'])) {
            return redirect()->route('order.history')->with('info', 'Pesanan sudah selesai.');
        }
        return view('payment', compact('order'));
    }

    public function addToCart(int $id)
{
    try {
        // Gunakan find alih-alih findOrFail agar tidak langsung melempar error 404
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu tidak ditemukan di database!'
            ], 404);
        }

        $cart = session()->get('cart', []);
        
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "nama_menu" => $menu->nama_menu,
                "quantity"  => 1,
                "harga"     => $menu->harga,
                "foto"      => $menu->foto
            ];
        }

        session()->put('cart', $cart);
        return response()->json(['success' => true, 'cart_count' => count($cart)]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false, 
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function updateStatus(Request $request, string $id)
    {
        $request->validate(['status' => 'required|in:pending,diproses,siap,sukses,batal']);
        $order = Order::findOrFail($id);
        $order->status = strtolower($request->status); 
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan #' . $order->id . ' diperbarui!');
    }
}