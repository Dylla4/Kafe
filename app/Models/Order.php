<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Baris ini memberi izin agar kolom-kolom ini bisa diisi data
    protected $fillable = [
        'user_id',
        'nama_pembeli', 
        'nomor_meja', 
        'catatan', 
        'item_pesanan', 
        'total_harga',
        'metode_pembayaran',
        'status'
    ];
}