<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function menu()
    {
        $menus = Menu::all();
        return view('menu', compact('menus'));
    }

    public function showCart()
    {
        $cartItems = session()->get('cart', []);
        $total_harga = 0;
        foreach($cartItems as $item) {
            $total_harga += (int)$item['harga'] * (int)$item['quantity'];
        }

        $semuaMeja = ['Meja 01', 'Meja 02', 'Meja 03', 'Meja 04', 'Meja 05'];
        $mejaTerpakai = Order::whereIn('status', ['diproses', 'dikemas'])->pluck('nomor_meja')->toArray();
        $mejaKosong = array_diff($semuaMeja, $mejaTerpakai);
        $mejaOtomatis = !empty($mejaKosong) ? reset($mejaKosong) : 'Penuh';

        return view('cart', compact('cartItems', 'total_harga', 'mejaOtomatis'));
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nama_pemesan'      => 'required|string|max:255',
            'nomor_meja'        => 'required',
            'metode_pembayaran' => 'required',
            'tanggal_booking'   => 'required|date',
            'jam_booking'       => 'required',
        ]);

        $request->validate([
        'tanggal_booking' => [
        'required',
        'date',
        'after_or_equal:today',
        'before_or_equal:' . now()->addDays(7)->format('Y-m-d')
        ],
        ]);

        $request->validate([
        'jam_booking' => [
        'required',
        function ($attribute, $value, $fail) {
            if ($value < "09:00" || $value > "22:00") {
                $fail('Pesanan hanya tersedia antara jam 09.00 - 22.00.');
                }
                },
            ],
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['success' => false, 'error' => 'Keranjang kosong!'], 400);
        }

        $total_harga = 0;
        foreach($cart as $item) {
            $total_harga += (int)$item['harga'] * (int)$item['quantity'];
        }

        try {
            $newOrder = Order::create([
                'user_id'           => Auth::id(), 
                'nama_pembeli'      => $request->nama_pemesan,
                'nomor_meja'        => $request->nomor_meja,
                'alamat'            => $request->alamat,
                'item_pesanan'      => $cart,
                'total_harga'       => $total_harga,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status'            => 'pending',
                'tanggal_booking'   => $request->tanggal_booking, 
                'jam_booking'       => $request->jam_booking,     
            ]);

            session()->forget('cart');

            return response()->json([
                'success' => true,
                'order_id' => $newOrder->id 
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'error' => 'Gagal menyimpan: ' . $e->getMessage()
            ], 500);
        }
        
    }

    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('history', compact('orders'));
    }

    public function addToCart(Request $request, $id)
    {
        try {
            $menu = Menu::findOrFail($id);
            $cart = session()->get('cart', []);

            if(isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    "nama_menu" => $menu->nama_menu,
                    "quantity"  => 1,
                    "harga"     => $menu->harga,
                    "foto"      => $menu->gambar
                ];
            }

            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil ditambahkan ke keranjang!',
                'cart_count' => count($cart)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function confirmPayment($id)
{
    try {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'sukses']); 

        // Kirim respon JSON, jangan Redirect!
        return response()->json([
            'success' => true,
            'message' => 'Pembayaran dikonfirmasi',
            'order_id' => $id // Kirim ID agar JS tahu struk mana yang dibuka
        ]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}

    public function printInvoice($id)
    {
        $order = Order::findOrFail($id);
        
        // Mendefinisikan $items agar loop @foreach di Blade berjalan lancar
        $items = is_array($order->item_pesanan) 
    ? $order->item_pesanan 
    : json_decode((string)$order->item_pesanan, true);
        
        return view('invoice', compact('order', 'items'));
    }

    public function showPayment($id)
    {
        $order = Order::findOrFail($id);
        return view('payment', compact('order'));
    }

    
}