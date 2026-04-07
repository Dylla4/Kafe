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
            'foto' => 'img/AlmoundCoffee.jpeg',
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Biskuit Coffee',
            'harga' => 22000,
            'kategori' => 'Minuman',
            'foto' => 'img/BiskiesCoffee.jpeg',
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Caramel Latte',
            'harga' => 20000,
            'kategori' => 'Minuman',
            'foto' => 'img/CaramelCoffee.jpeg',
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Hot Chocolate',
            'harga' => 20000,
            'kategori' => 'Minuman',
            'foto' => 'img/ChocolateHot.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Coffee Latte',
            'harga' => 20000,
            'kategori' => 'Minuman',
            'foto' => 'img/CoffeLattee.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Matcha Latte',
            'harga' => 22000,
            'kategori' => 'Minuman',
            'foto' => 'img/MatchaLatte.jpg'
        ]);

        Menu::create([
            'nama_menu' => 'Strawberry Milkshake',
            'harga' => 21000,
            'kategori' => 'Minuman',
            'foto' => 'img/StrawberryMilkshake.jpg'
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
            'nama_menu' => 'Ayam Crispy',
            'harga' => 15000,
            'kategori' => 'Makanan',
            'foto' => 'img/AyamCrispy.jpeg'
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
            'nama_menu' => 'Nugget Ayam',
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
            'harga' => 25000,
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
            'foto' => 'img/Salmon.jpeg',
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Sate Ayam Spesial',
            'harga' => 40000,
            'kategori' => 'Makanan',
            'foto' => 'img/Sateayam.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Hamburger Ayam',
            'harga' => 20000,
            'kategori' => 'Makanan',
            'foto' => 'img/Burgerayaam.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Hamburger Beef',
            'harga' => 23000,
            'kategori' => 'Makanan',
            'foto' => 'img/Burgerbeef.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'French Fries',
            'harga' => 13000,
            'kategori' => 'Makanan',
            'foto' => 'img/KentangGoreng.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Chocolate Cake',
            'harga' => 20000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/ChocolateCake.jpeg',
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Original Churros',
            'harga' => 10000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/Churros.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Original Croissant',
            'harga' => 20000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/Croissant.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Lemon Cheesecake',
            'harga' => 20000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/LemonCheesecake.jpg',
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Oreo Cheesecake',
            'harga' => 20000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/OreoCheesecake.jpg'
        ]);

        Menu::create([
            'nama_menu' => 'Almond Croissant',
            'harga' => 25000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/CroissantAlmond.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Chocolate Croissant',
            'harga' => 23000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/Croissantcoklat.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Chocolate Almond Croissant',
            'harga' => 26000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/CroissantCoklatAlmond.jpeg',
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Matcha Croissant',
            'harga' => 23000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/CroissantMatcha.jpeg',
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Hotdog',
            'harga' => 15000,
            'kategori' => 'Makanan',
            'foto' => 'img/hotdog.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'French Fries',
            'harga' => 15000,
            'kategori' => 'Makanan',
            'foto' => 'img/KentangGoreng.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Lumpia',
            'harga' => 17000,
            'kategori' => 'Makanan',
            'foto' => 'img/Lumpiah.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Mozzarella Pizza',
            'harga' => 53000,
            'kategori' => 'Makanan',
            'foto' => 'img/pizzamoza.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Sosis Bakar',
            'harga' => 15000,
            'kategori' => 'Makanan',
            'foto' => 'img/sosisbakar.jpeg'
        ]);

        Menu::create([
            'nama_menu' => 'Strawberry Cheesecake',
            'harga' => 25000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/StrawberryCheesecake.jpg',
            'is_best_seller' => true
        ]);
    }
}