<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 
        'nama_pembeli', 
        'nomor_meja', 
        'alamat',    
        'catatan',   
        'item_pesanan', 
        'total_harga', 
        'metode_pembayaran', 
        'status',
        'tanggal_booking', 
        'jam_booking'
    ];

    protected $casts = [
        'item_pesanan' => 'array', // Mengonversi JSON DB ke Array PHP otomatis
    ];
}