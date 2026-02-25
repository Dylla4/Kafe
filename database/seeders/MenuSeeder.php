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
            'nama_menu' => 'Americano',
            'harga' => 19000,
            'kategori' => 'Minuman',
            'foto' => 'img/Americano.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Almond Coffee',
            'harga' => 25000,
            'kategori' => 'Minuman',
            'foto' => 'img/AlmoundCoffee.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Biskuit Coffee',
            'harga' => 22000,
            'kategori' => 'Minuman',
            'foto' => 'img/BiskiesCoffee.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Caramel Latte',
            'harga' => 20000,
            'kategori' => 'Minuman',
            'foto' => 'img/CaramelCoffee.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Chocolate',
            'harga' => 20000,
            'kategori' => 'Minuman',
            'foto' => 'img/Chocolate.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Coffee Latte',
            'harga' => 20000,
            'kategori' => 'Minuman',
            'foto' => 'img/CoffeLattee.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Dalgona Coffee',
            'harga' => 20000,
            'kategori' => 'Minuman',
            'foto' => 'img/Dalgona.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Gula Aren Coffee',
            'harga' => 18000,
            'kategori' => 'Minuman',
            'foto' => 'img/GulaAren.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Lemon Coffee',
            'harga' => 18000,
            'kategori' => 'Minuman',
            'foto' => 'img/LemonCoffee.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Ayam Geprek',
            'harga' => 17000,
            'kategori' => 'Makanan',
            'foto' => 'img/AyamGeprek.jpeg'
        ]);
        
        Menu::create([
            'nama_menu' => 'Dimsum Mentai',
            'harga' => 40000,
            'kategori' => 'Makanan',
            'foto' => 'img/DimsumMentai.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Gimbap',
            'harga' => 35000,
            'kategori' => 'Makanan',
            'foto' => 'img/Gimbap.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Naget Ayam',
            'harga' => 30000,
            'kategori' => 'Makanan',
            'foto' => 'img/Naget.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Nasi Goreng Spesial',
            'harga' => 25000,
            'kategori' => 'Makanan',
            'foto' => 'img/nasigoreng.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Onigiri',
            'harga' => 35000,
            'kategori' => 'Makanan',
            'foto' => 'img/Onigiri.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Rice Bowl Ayam Geprek',
            'harga' => 27000,
            'kategori' => 'Makanan',
            'foto' => 'img/RiceBawll.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Rice Bowl Ayam Crispy',
            'harga' => 27000,
            'kategori' => 'Makanan',
            'foto' => 'img/RiceBawllAyam.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Sushi Salmon',
            'harga' => 45000,
            'kategori' => 'Makanan',
            'foto' => 'img/Salmon.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Sate Ayam Spesial',
            'harga' => 40000,
            'kategori' => 'Makanan',
            'foto' => 'img/Sateayam.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Hamberger Ayam',
            'harga' => 25000,
            'kategori' => 'Makanan',
            'foto' => 'img/Burgerayaam.jpeg'
        ]);
    }
}