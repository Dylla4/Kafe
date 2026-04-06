<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 
        'nama_pembeli', 
        'nomor_meja', 
        'alamat',    // Tambahkan ini (ada di database)
        'catatan',   // Tambahkan ini (ada di database)
        'item_pesanan', 
        'total_harga', 
        'metode_pembayaran', 
        'status',
        'tanggal_booking', 
        'jam_booking'
    ];

    protected $casts = [
        'item_pesanan' => 'array', // Penting agar JSON database otomatis jadi Array PHP
    ];
}