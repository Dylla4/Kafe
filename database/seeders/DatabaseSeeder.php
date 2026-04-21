<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Schema; // Tambahkan ini

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // MATIKAN pengecekan foreign key agar truncate tidak error
        Schema::disableForeignKeyConstraints();

        // 1. Panggil Seeder Menu
        $this->call([
            MenuSeeder::class,
        ]);

        // 2. Seed untuk Tabel Users (Pelanggan)
        User::truncate(); 
        User::create([
            'name' => 'Sha',
            'email' => 'sha12@gmail.com',
            'password' => bcrypt('akun12345'),
            'nomor_wa' => '6282115937845',
        ]);

        // 3. Seed untuk Tabel Admins (Pengelola)
        Admin::truncate();
        Admin::create([
            'email' => 'admin@valeriacoffee.id',
            'password' => bcrypt('admin123'),
        ]);

        // HIDUPKAN kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();
    }
}