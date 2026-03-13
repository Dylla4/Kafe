<?php

namespace Database\Seeders;

use App\Models\User; // Pastikan namespace ini ada
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Penting untuk meng-hash password

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Menambahkan User Admin secara manual
        User::create([
            'name' => 'Admin Valeria',
            'email' => 'admin@valeriacoffee.id',
            'password' => Hash::make('password'), // Ganti dengan password pilihan Anda
        ]);

        // 2. Memanggil Seeder lainnya
        $this->call([
            MenuSeeder::class,
        ]);
    }
}