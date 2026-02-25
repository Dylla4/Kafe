<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class AdminOrderController extends Controller
{
    protected Database $db;

    public function __construct()
    {
        $credPath = base_path(env('FIREBASE_CREDENTIALS'));
        $dbUrl    = env('FIREBASE_DATABASE_URL');

        if (!file_exists($credPath)) {
            throw new \RuntimeException("Firebase credentials tidak ditemukan: {$credPath}");
        }
        if (!$dbUrl) {
            throw new \RuntimeException("FIREBASE_DATABASE_URL belum di-set di .env");
        }

        $factory = (new Factory)
            ->withServiceAccount($credPath)
            ->withDatabaseUri($dbUrl);

        $this->db = $factory->createDatabase();
    }

    public function index()
    {
        $orders = $this->db->getReference('orders')->getValue() ?? [];
        return view('admin.orders', compact('orders'));
    }

    // ✅ STATUS MANUAL (sesuai dropdown)
    public function nextStatus($id)
    {
        $status = request('status');

        $valid = ['pending', 'diproses', 'selesai'];

        if (!in_array($status, $valid, true)) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }

        $orderRef = $this->db->getReference("orders/{$id}");
        $order    = $orderRef->getValue();

        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan');
        }

        $orderRef->update([
            'status'     => $status,
            'updated_at' => now()->toDateTimeString(),
        ]);

        return redirect()->back()->with('success', "Status diubah ke {$status}");
    }
}