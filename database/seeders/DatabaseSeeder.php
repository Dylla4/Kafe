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
        Schema::disableForeignKeyConstraints();

        $this->call([
            MenuSeeder::class,
        ]);

        User::truncate(); 
        User::create([
            'name' => 'Sha',
            'email' => 'sha12@gmail.com',
            'password' => bcrypt('akun12345'),
            'nomor_wa' => '6282115937845',
        ]);

        Admin::truncate();
        Admin::create([
            'email' => 'admin@valeriacoffee.id',
            'password' => bcrypt('admin123'),
        ]);

        Schema::enableForeignKeyConstraints();
    }
}