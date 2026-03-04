<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() 
    {
        $today = date('Ymd'); 
        $promoMenus = Menu::inRandomOrder($today)->take(2)->get();
        $menus = Menu::all();
        
        return view('welcome', compact('menus', 'promoMenus'));
    }

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

    public function remove($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Menu dihapus dari keranjang.');
    }

    public function showCart()
    {
        $cartItems = session()->get('cart', []);
        return view('cart', compact('cartItems'));
    }

    /**
     * Menyimpan data pesanan dengan pilihan metode pembayaran.
     */
    public function simpan(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang masih kosong!');
        }

        $total = 0;
        foreach($cart as $item) { 
            $total += $item['harga'] * $item['quantity']; 
        }

        $lokasi = $request->nomor_meja;
        if (empty($lokasi)) {
            $lokasi = ($request->jenis_pesanan == 'take_away') ? 'Alamat Tidak Diisi' : 'Tanpa Meja';
        }

        // Simpan ke Database termasuk metode_pembayaran
        $order = Order::create([
            'nama_pembeli'      => $request->nama_pembeli,
            'nomor_meja'        => $lokasi,
            'catatan'           => $request->catatan ?? '-',
            'item_pesanan'      => json_encode($cart),
            'total_harga'       => $total,
            'metode_pembayaran' => $request->metode_pembayaran, // Pastikan kolom ini ada di migrasi database
            'status'            => ($request->metode_pembayaran == 'cash') ? 'diproses' : 'menunggu_pembayaran'
        ]);

        session()->forget('cart');

        // Logika Pengalihan Halaman
        if ($request->metode_pembayaran == 'cash') {
            // Jika Cash langsung ke Struk
            return redirect()->route('invoice.print', $order->id)->with('success', 'Pesanan diterima!');
        } else {
            // Jika QRIS/Transfer ke halaman Scan/Instruksi
            return redirect()->route('order.payment', $order->id);
        }
    }

    /**
     * Menampilkan halaman instruksi pembayaran (QRIS/Transfer).
     */
    public function showPayment($id)
    {
        $order = Order::findOrFail($id);
        return view('payment', compact('order'));
    }

    /**
     * Simulasi konfirmasi pembayaran sukses.
     */
    public function confirmPayment($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'sukses']); // Update status jadi sukses

        return redirect()->route('invoice.print', $order->id)->with('success', 'Pembayaran Sukses!');
    }

    /**
 * Menampilkan riwayat pesanan pelanggan.
 */
public function history()
{
    // Mengambil semua pesanan dari database MySQL
    $orders = Order::orderBy('created_at', 'desc')->get();
    
    return view('history', compact('orders'));
}


/**
 * Menampilkan invoice pesanan pelanggan.
 */
    public function printInvoice($id)
    {
        $order = Order::findOrFail($id);
        $items = json_decode($order->item_pesanan, true);
        return view('invoice', compact('order', 'items'));
    }
}