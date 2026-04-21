<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Ulasan extends Model
{
    use HasFactory;

    // Menentukan kolom mana saja yang boleh diisi secara massal
    protected $fillable = [
        'user_id',
        'order_id',
        'nama', 
        'komentar', 
        'rating', 
        'foto'
    ];

    /**
     * Opsional: Helper untuk mendapatkan URL foto yang valid.
     * Jika di Blade Anda panggil $ulasan->foto_url, 
     * ia akan otomatis mengecek apakah ada fotonya atau tidak.
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return asset('storage/' . $this->foto);
        }

        // Jika tidak ada foto, bisa berikan gambar default atau null
        return null; 
    }
}