<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan halaman utama dengan menu reguler dan menu promo harian.
     */
    public function index() 
    {
        $today = date('Ymd'); 
        $promoMenus = Menu::inRandomOrder($today)->take(2)->get();
        $menus = Menu::all();
        
        return view('welcome', compact('menus', 'promoMenus'));
    }

    /**
     * Menambahkan menu ke keranjang (Session).
     */
    public function addToCart($id)
    {
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
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
     * Mengurangi jumlah item di keranjang.
     */
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

        return redirect()->back()->with('success', 'Jumlah menu diperbarui.');
    }

    /**
     * Menghapus item sepenuhnya dari keranjang.
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
     * Menampilkan halaman keranjang belanja.
     */
    public function showCart()
    {
        $cartItems = session()->get('cart', []);
        return view('cart', compact('cartItems'));
    }

    /**
     * Menyimpan data pesanan dan langsung mengarahkan ke cetak struk.
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

        // Logika penentuan lokasi (Meja vs Alamat)
        $lokasi = $request->nomor_meja;
        if (empty($lokasi)) {
            $lokasi = ($request->jenis_pesanan == 'take_away') ? 'Alamat Tidak Diisi' : 'Tanpa Meja';
        }

        // Simpan ke Database dan ambil objek hasil simpan ke variabel $order
        $order = Order::create([
            'nama_pembeli' => $request->nama_pembeli,
            'nomor_meja'   => $lokasi,
            'catatan'      => $request->catatan ?? '-',
            'item_pesanan' => json_encode($cart),
            'total_harga'  => $total,
            'status'       => 'diproses'
        ]);

        // Kosongkan keranjang setelah berhasil pesan
        session()->forget('cart');

        // Redirect langsung ke halaman cetak struk berdasarkan ID pesanan baru
        return redirect()->route('invoice.print', $order->id)->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * Menampilkan halaman struk (Invoice) untuk dicetak.
     */
    public function printInvoice($id)
    {
        // Mengambil data pesanan berdasarkan ID
        $order = Order::findOrFail($id);
        
        // Decode data JSON item pesanan agar bisa dibaca di Blade
        $items = json_decode($order->item_pesanan, true);

        return view('invoice', compact('order', 'items'));
    }
}