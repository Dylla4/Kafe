<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class OrderController extends Controller
{
    // =========================
    // KERANJANG (SESSION)
    // =========================
    public function addToCart($id)
    {
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "nama_menu" => $menu->nama_menu,
                "quantity"  => 1,
                "harga"     => (int) $menu->harga,
                "kategori"  => $menu->kategori,
                "foto"      => $menu->foto,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu ditambahkan!');
    }

    public function decrease($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            if (($cart[$id]['quantity'] ?? 1) > 1) {
                $cart[$id]['quantity']--;
            } else {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }
        return redirect()->back();
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back();
    }

    public function showCart()
    {
        return view('cart');
    }

    // =========================
    // CHECKOUT -> SIMPAN ORDER
    // =========================
    public function simpan(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:100',
            'nomor_meja'   => 'required|string|max:20',
            'catatan'      => 'nullable|string|max:255',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        // hitung total
        $total = 0;
        foreach ($cart as $item) {
            $harga = (int) ($item['harga'] ?? 0);
            $qty   = (int) ($item['quantity'] ?? 1);
            $total += $harga * $qty;
        }

        // =========================
        // 1) SIMPAN KE SQLITE (opsional)
        // =========================
        $order = Order::create([
            'nama_pembeli' => $request->nama_pembeli,
            'nomor_meja'   => $request->nomor_meja,
            'catatan'      => $request->catatan ?? '-',
            'item_pesanan' => json_encode($cart),
            'total_harga'  => $total,
            'status'       => 'pending',
        ]);

        // =========================
        // 2) SIMPAN KE FIREBASE RTDB
        // =========================
        $credPath = base_path(env('FIREBASE_CREDENTIALS'));
        $dbUrl    = env('FIREBASE_DATABASE_URL');

        if (!file_exists($credPath)) {
            return redirect()->back()->with('error', "Credential Firebase tidak ditemukan: $credPath");
        }
        if (!$dbUrl) {
            return redirect()->back()->with('error', "FIREBASE_DATABASE_URL belum diisi di .env");
        }

        $factory = (new Factory)
            ->withServiceAccount($credPath)
            ->withDatabaseUri($dbUrl);

        $database = $factory->createDatabase();

        // pakai ID dari SQLite biar sinkron, atau bisa pakai push() kalau mau auto key
        $orderId = (string) $order->id;

        $database->getReference("orders/$orderId")->set([
            'id'          => (int) $order->id,
            'nama_pembeli'=> $request->nama_pembeli,
            'nomor_meja'  => $request->nomor_meja,
            'catatan'     => $request->catatan ?? '-',
            'items'       => $cart,
            'total_harga' => (int) $total,
            'status'      => [
                'code'       => 'pending',
                'label'      => 'Menunggu',
                'updated_at' => now()->toDateTimeString(),
            ],
            'created_at'  => now()->toDateTimeString(),
        ]);

        session()->forget('cart');
        return redirect('/')->with('success', 'Pesanan terkirim & masuk Firebase!');
    }
}