<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin; // Pastikan Model Admin di-import

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Panggil Seeder Menu yang sudah kamu buat tadi
        $this->call([
            MenuSeeder::class,
        ]);

        // 2. Seed untuk Tabel Users (Pelanggan)
        User::truncate(); 
        User::create([
            'name' => 'Sha',
            'email' => 'sha12@gmail.com',
            'password' => bcrypt('akun12345'),
        ]);

        // 3. Seed untuk Tabel Admins (Pengelola)
        // Pastikan tabel 'admins' sudah ada di migration kamu
        Admin::truncate();
        Admin::create([
            'email' => 'admin@valeriacoffee.id',
            'password' => bcrypt('admin123'),
        ]);
    }
}