<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_pesanan', 
        'user_id', 
        'nama_pemesan', 
        'nomor_wa', 
        'jenis_pesanan', 
        'metode_pembayaran', // Pastikan ini ada
        'alamat', 
        'nomor_meja', 
        'item_pesanan', 
        'total_bayar', 
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ulasan(): HasOne
    {
        return $this->hasOne(Ulasan::class, 'order_id');
    }

    protected function casts(): array
    {
        return [
            'item_pesanan'    => 'array',
            'tanggal_booking' => 'date',
            'total_bayar'     => 'integer',
        ];
    }
}