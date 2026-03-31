<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menghapus data user lama agar tidak duplikat saat seeder dijalankan ulang
        User::truncate();

        User::create([
            'name' => 'Admin Valeria',
            'email' => 'admin@valeriacoffee.id',
            'password' => bcrypt('admin123'),
        ]);
    }
}