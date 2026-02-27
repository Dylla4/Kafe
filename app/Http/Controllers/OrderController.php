<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Fungsi 1: Menambahkan menu ke keranjang (Session).
     * Digunakan oleh tombol "+ Tambah ke Pesanan" di halaman utama 
     * dan tombol "+" di halaman keranjang.
     */
    public function addToCart($id)
    {
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Key harus sama dengan yang dipanggil di file Blade
            $cart[$id] = [
                "nama_menu" => $menu->nama_menu,
                "quantity"  => 1,
                "harga"     => $menu->harga,
                "foto"      => $menu->foto,
                "kategori"  => $menu->kategori
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Fungsi 2: Mengurangi jumlah item di keranjang.
     * Digunakan oleh tombol "-" di halaman keranjang.
     */
    public function decrease($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            if($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            } else {
                // Jika jumlah tinggal 1 dan dikurangi, hapus item dari keranjang
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Jumlah menu diperbarui.');
    }

    /**
     * Fungsi 3: Menghapus item sepenuhnya dari keranjang.
     * Digunakan oleh tombol "Hapus/Cancel" (ikon tong sampah).
     */
    public function remove($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Menu dihapus dari keranjang.');
    }

    /**
     * Fungsi 4: Menampilkan halaman keranjang belanja.
     */
    public function showCart()
    {
        $cartItems = session()->get('cart', []);
        return view('cart', compact('cartItems'));
    }

    /**
     * Fungsi 5: Menyimpan data pesanan dari form ke tabel 'orders'.
     */
    public function simpan(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang masih kosong!');
        }

        // Hitung Total Harga
        $total = 0;
        foreach($cart as $item) { 
            $total += $item['harga'] * $item['quantity']; 
        }

        // Simpan ke Database
        Order::create([
            'nama_pembeli' => $request->nama_pemesan, // 'nama_pemesan' dari input form
            'nomor_meja'   => $request->nomor_meja ?? 0,
            'catatan'      => $request->catatan ?? '-',
            'item_pesanan' => json_encode($cart),
            'total_harga'  => $total,
            'status'       => 'pending'
        ]);

        // Kosongkan keranjang setelah berhasil pesan
        session()->forget('cart');

        return redirect('/')->with('success', 'Pesanan Anda telah kami terima!');
    }
}