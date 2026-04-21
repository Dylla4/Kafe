<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 
        'nama_pemesan', 
        'nomor_meja',
        'nomor_pesanan',
        'jenis_pesanan', 
        'alamat',
        'nomor_wa',    
        'catatan',   
        'item_pesanan', 
        'total_bayar', 
        'metode_pembayaran', 
        'status',
        'tanggal_booking', 
        'jam_booking'
    ];

    /**
     * Relasi ke User (Pemesan)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Ulasan (Review)
     */
    public function review() 
    {
        return $this->hasOne(Ulasan::class, 'order_id');
    }

    /**
     * Casting data otomatis
     */
    protected $casts = [
        'item_pesanan' => 'array', 
        'tanggal_booking' => 'date', // Tambahan agar format tanggal lebih konsisten
    ];
}