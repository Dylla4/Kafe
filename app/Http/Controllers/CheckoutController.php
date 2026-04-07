<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Pesanan; // Pastikan ini sesuai dengan folder Model Anda

class CheckoutController extends Controller
{
    public function simpan(Request $request)
    {
        // 1. Konfigurasi Midtrans - PASTIKAN SERVER KEY BENAR
        Config::$serverKey = 'SB-Mid-server-xxxxxxxxxxxx'; // Ganti dengan key dari Dashboard Midtrans
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // 2. Cek Keranjang
        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return response()->json(['error' => 'Keranjang kosong!'], 400);
        }

        $totalHarga = 0;
        foreach ($cartItems as $item) {
            $totalHarga += $item['harga'] * $item['quantity'];
        }

        // 3. SIMPAN KE DATABASE (Langkah ini membuat pesanan langsung muncul di Riwayat)
        try {
            $orderId = 'KAFE-' . time();
            $pesanan = new Pesanan(); 
            $pesanan->order_id = $orderId;
            $pesanan->nama_pemesan = $request->nama_pemesan;
            $pesanan->jenis_pesanan = $request->jenis_pesanan;
            $pesanan->alamat = $request->alamat;
            $pesanan->nomor_meja = $request->nomor_meja;
            $pesanan->metode_pembayaran = $request->metode_pembayaran;
            $pesanan->catatan = $request->catatan;
            $pesanan->total_harga = $totalHarga;
            $pesanan->status = 'pending'; // Status awal agar muncul di riwayat
            $pesanan->save(); 
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal simpan ke database: ' . $e->getMessage()], 500);
        }

        // 4. Proses Midtrans jika pilih Transfer
        if ($request->metode_pembayaran === 'transfer') {
            try {
                $params = [
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => (int)$totalHarga,
                    ],
                    'customer_details' => [
                        'first_name' => $request->nama_pemesan,
                    ],
                    'enabled_payments' => ['dana', 'gopay', 'shopeepay'],
                ];

                $snapToken = Snap::getSnapToken($params);
                
                // Jangan hapus keranjang dulu untuk transfer (hapus setelah bayar di success callback)
                return response()->json([
                    'snap_token' => $snapToken,
                    'order_id' => $orderId
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Gagal konek Midtrans: ' . $e->getMessage()], 500);
            }
        }

        // 5. Jika pilih Cash, hapus keranjang dan sukses
        session()->forget('cart');
        return response()->json(['success' => true]);
    }
}