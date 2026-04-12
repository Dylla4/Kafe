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
        
        $total_harga = collect($cartItems)->sum(function($item) {
            return (int)$item['harga'] * (int)$item['quantity'];
        });

        // Logika Nomor Meja Otomatis (Hanya untuk Dine In)
        $semuaMeja = ['Meja 01', 'Meja 02', 'Meja 03', 'Meja 04', 'Meja 05', 'Meja 06', 'Meja 07', 'Meja 08', 'Meja 09', 'Meja 10'];
        $mejaTerpakai = Order::whereIn('status', ['pending', 'diproses', 'dikemas', 'sukses'])
                             ->whereNotNull('nomor_meja')
                             ->pluck('nomor_meja')
                             ->toArray();
                             
        $mejaKosong = array_diff($semuaMeja, $mejaTerpakai);
        $mejaOtomatis = !empty($mejaKosong) ? reset($mejaKosong) : 'Penuh';

        return view('cart', compact('cartItems', 'total_harga', 'mejaOtomatis'));
    }

    public function simpan(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_pemesan'      => 'required|string|max:255',
            'metode_pembayaran' => 'required',
            'jenis_pesanan'     => 'required', // dine_in, delivery, atau take_away
            'tanggal_booking'   => 'required|date|after_or_equal:today',
            'jam_booking'       => 'required',
        ]);

        // 2. Validasi Jam Operasional (09:00 - 22:00)
        if ($request->jam_booking < "09:00" || $request->jam_booking > "22:00") {
            return response()->json(['success' => false, 'error' => 'Jam operasional 09:00 - 22:00'], 422);
        }

        // 3. Validasi Keranjang
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['success' => false, 'error' => 'Keranjang Anda masih kosong!'], 400);
        }

        // 4. Hitung Total Harga
        $total_harga = collect($cart)->sum(function($item) {
            return (int)$item['harga'] * (int)$item['quantity'];
        });

        // 5. Logika Nomor Pesanan (Antrean Baru)
        // Format: INV-Tgl-Urutan (Contoh: INV-20260411-001)
        $jumlahPesananHariIni = Order::whereDate('created_at', today())->count() + 1;
        $nomorPesanan = 'INV-' . date('Ymd') . '-' . str_pad($jumlahPesananHariIni, 3, '0', STR_PAD_LEFT);

        // 6. Logika Penentuan Nomor Meja
        $nomorMeja = null; 
        if ($request->jenis_pesanan === 'dine_in') {
            $nomorMeja = $request->nomor_meja;
        }

        try {
            // 7. Simpan Pesanan ke Database
            $newOrder = Order::create([
                'user_id'           => Auth::id(), 
                'nomor_pesanan'     => $nomorPesanan, // Simpan ke kolom baru
                'nama_pembeli'      => $request->nama_pemesan,
                'nomor_meja'        => $nomorMeja,    // Akan null jika bukan dine_in
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
                'error' => 'Gagal menyimpan pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showPayment($id)
    {
        $order = Order::findOrFail($id);
        
        if (in_array($order->status, ['sukses', 'lunas', 'diproses'])) {
            return redirect()->route('order.history')->with('info', 'Pesanan ini sudah dalam tahap pemrosesan.');
        }

        return view('payment', compact('order'));
    }

    public function confirmPayment($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->update(['status' => 'sukses']); 

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dikonfirmasi!',
                'order_id' => $id 
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal konfirmasi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function sendEmail($id)
    {
        try {
            $order = Order::findOrFail($id);
            return redirect()->back()->with('success', 'Fitur email sedang dalam pengembangan, tetapi data pesanan ' . $order->nomor_pesanan . ' ditemukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menemukan pesanan: ' . $e->getMessage());
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
        $menu = Menu::findOrFail($id);
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

        return response()->json([
            'success' => true,
            'cart_count' => count($cart)
        ]);
    }

    public function showReceipt($id)
{
    // Ambil data pesanan berdasarkan ID
    $order = Order::findOrFail($id);

    // Tampilkan view struk yang sudah Anda buat sebelumnya
    return view('orders.receipt', compact('order'));
}

public function showReservation($id)
{
    $order = Order::findOrFail($id);
    
    // Pastikan memanggil 'reservation_proof' saja jika filenya di resources/views/
    return view('reservation_proof', compact('order'));
}

public function konfirmasi($id)
{
    $order = Order::findOrFail($id);
    $order->update(['status' => 'sukses']); 

    // Jika Dine In (ada nomor meja) -> ke Bukti Reservasi
    if ($order->nomor_meja) {
        return redirect()->route('order.reservation', $order->id);
    }

    // Jika Take Away / Delivery (tidak ada nomor meja) -> ke Receipt
    return redirect()->route('order.receipt', $order->id);
}

// Di dalam OrderController.php
public function receipt($id)
{
    $order = Order::findOrFail($id);
    
    // PERBAIKAN: Langsung panggil 'receipt' karena filenya ada di views/receipt.blade.php
    return view('receipt', compact('order'));
}
    public function printInvoice($id)
    {
        $order = Order::findOrFail($id);
        
        $items = is_array($order->item_pesanan) 
                 ? $order->item_pesanan 
                 : json_decode((string)$order->item_pesanan, true);
        
        return view('invoice', compact('order', 'items'));
    }

public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);

    // Ubah ke strtolower agar sinkron dengan database "sukses"
    $order->status = strtolower($request->status); 
    $order->save();

    return redirect()->back()->with('success', 'Status diperbarui!');
}
}