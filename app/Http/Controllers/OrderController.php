<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Fungsi 1: Menambahkan menu ke keranjang
    public function addToCart($id)
    {
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // DISAMAKAN: menggunakan nama_menu dan harga agar terbaca di Blade
            $cart[$id] = [
                "nama_menu" => $menu->nama_menu,
                "quantity" => 1,
                "harga" => $menu->harga,
                "kategori" => $menu->kategori,
                "foto" => $menu->foto
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu ditambahkan!');
    }

    // Fungsi tambahan: Mengurangi jumlah item di keranjang
    public function decrease($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            if($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            } else {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }
        return redirect()->back();
    }

    // Fungsi tambahan: Menghapus item sepenuhnya
    public function remove($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back();
    }

    public function showCart()
    {
        // Mengambil data cart untuk dikirim ke view
        $cartItems = session()->get('cart', []);
        return view('cart', compact('cartItems'));
    }

    public function simpan(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->back();

        $total = 0;
        foreach($cart as $item) { 
            $total += $item['harga'] * $item['quantity']; 
        }

        Order::create([
            'nama_pembeli' => $request->nama_pemesan, // Sesuaikan dengan name="nama_pemesan" di form
            'nomor_meja'   => $request->nomor_meja ?? 0,
            'catatan'      => $request->catatan ?? '-',
            'item_pesanan' => json_encode($cart),
            'total_harga'  => $total,
            'status'       => 'pending'
        ]);

        session()->forget('cart');
        return redirect('/')->with('success', 'Pesanan terkirim!');
    }
}