<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::truncate(); // supaya tidak duplikat

        Menu::create([
            'nama_menu' => 'Kopi Susu Gula Aren',
            'harga' => 15000,
            'kategori' => 'Kopi',
            'foto' => 'img/kopi_gula_aren.jpg'
        ]);

        Menu::create([
            'nama_menu' => 'Espresso Single',
            'harga' => 10000,
            'kategori' => 'Kopi',
            'foto' => 'img/espresso.jpg'
        ]);

        Menu::create([
            'nama_menu' => 'Croissant Coklat',
            'harga' => 20000,
            'kategori' => 'Makanan',
            'foto' => 'img/chocolate_croissant.jpg'
        ]);

        Menu::create([
            'nama_menu' => 'Donat Cokelat',
            'harga' => 20000,
            'kategori' => 'Makanan',
            'foto' => 'img/donat_coklat.jpg'
        ]);
    }
}