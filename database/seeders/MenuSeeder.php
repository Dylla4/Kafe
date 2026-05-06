<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::truncate();

        Menu::create([
            'nama_menu' => 'Americano',
            'harga'     => 19000,
            'kategori'  => 'Coffee',
            'foto'      => 'img/Americano.jpeg',
            'deskripsi' => "Nikmati kesegaran Americano Coffee dengan cita rasa kopi hitam yang bold, smooth, dan autentik.\n\n" .
                            "Komposisi Utama: Double Shot Espresso, Water."
        ]);

Menu::create([
    'nama_menu' => 'Almond Coffee',
    'harga' => 25000,
    'kategori' => 'Coffee',
    'foto' => 'img/AlmoundCoffee.jpeg',
    'deskripsi' => "Nikmati perpaduan bold dari espresso premium dan creamy-nya susu segar dengan sentuhan sirup almond yang aromatik. Disajikan dingin dengan topping whipped cream lembut dan taburan kacang almond panggang yang renyah. Pilihan sempurna untuk penyemangat harimu.<br><br>" .
                   "<b>Komposisi Utama:</b> Espresso, Fresh Milk, Almond Syrup, Whipped Cream, Roasted Almond.<br><br>" .
                   "<b>Pilihan:</b><br>" .
                   "- Ukuran: Regular / Large (+5rb)<br>" .
                   "- Gula: Less / Normal / Extra<br>" .
                   "- Es: Less / Normal / Extra",
    'is_best_seller' => true
]);

        Menu::create([
            'nama_menu' => 'Biskuit Coffee',
            'harga' => 22000,
            'kategori' => 'Coffee',
            'foto' => 'img/BiskiesCoffee.jpeg',
            'deskripsi' => "Kopi susu vanila premium dengan topping whipped cream melimpah dan taburan biskuit crunchy. Cara manis untuk menikmati kopi dengan gaya modern.\n\n".
                            "Komposisi Utama: Espresso, Milk, Vanilla, Cookie Crumbs, Whipped Cream.",
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Caramel Latte',
            'harga' => 20000,
            'kategori' => 'Coffee',
            'foto' => 'img/CaramelCoffee.jpeg',
            'deskripsi' => "Kopi susu lembut dengan sensasi manis karamel yang mewah. Pilihan tepat untuk kamu yang menginginkan kopi creamy dengan aroma karamel yang memanjakan lidah.\n\n".
                            "Komposis Utama: Espresso, Fresh Milk, Premium Caramel Syrup.",
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Hot Chocolate',
            'harga' => 20000,
            'kategori' => 'Non-Coffee',
            'foto' => 'img/ChocolateHot.jpeg',
            'deskripsi' => "Nikmati kelembutan cokelat premium yang creamy dan silky. Minuman klasik yang tak lekang oleh waktu, cocok untuk kamu yang menginginkan ketenangan di tengah hari yang sibuk.\n\n".
                            "Komposisi Utama: Premium Cocoa Blend, Steamed Milk, Foam."
        ]);

        Menu::create([
            'nama_menu' => 'Coffee Latte',
            'harga' => 20000,
            'kategori' => 'Coffee',
            'foto' => 'img/CoffeLattee.jpeg',
            'deskripsi' => "Nikmati harmoni rasa espresso pilihan dan kelembutan susu segar. Teksturnya yang creamy dan rasanya yang halus menjadikan minuman ini teman terbaik untuk segala suasana.\n\n".
                            "Komposisi Utama: Espresso, Steamed Milk, Micro-foam."
        ]);

        Menu::create([
            'nama_menu' => 'Matcha Latte',
            'harga' => 22000,
            'kategori' => 'Non-Coffee',
            'foto' => 'img/MatchaLatte.jpg',
            'deskripsi' => "Perpaduan sempurna finest matcha dan susu segar yang lembut. Minuman kaya antioksidan dengan rasa yang halus dan aroma menenangkan. Cocok dinikmati panas maupun dingin.\n\n".
                            "Komposisi Utama: Premium Matcha, Fresh Milk."
        ]);

        Menu::create([
            'nama_menu' => 'Strawberry Milkshake',
            'harga' => 21000,
            'kategori' => 'Non-Coffee',
            'foto' => 'img/StrawberryMilkshake.jpg',
            'deskripsi' => "Manjakan dirimu dengan kelembutan susu segar dan ekstrak stroberi premium yang di-blend sempurna. Minuman manis yang dingin dan mengenyangkan, lengkap dengan whipped cream di atasnya.\n\n".
                            "Komposisi Utama: Strawberry, Fresh Milk, Vanilla Ice Cream, Whipped Cream."
        ]);

        Menu::create([
            'nama_menu' => 'Dalgona Coffee',
            'harga' => 20000,
            'kategori' => 'Coffee',
            'foto' => 'img/Dalgona.jpeg',
            'deskripsi' => "Perpaduan estetik dari susu segar dingin dan busa kopi kental yang manis di atasnya. Cara seru dan creamy untuk menikmati kopi dingin yang sedang tren.\n\n".
                            "Komposisi Utama: Coffee Foam, Fresh Milk, Ice, Brown Sugar."
        ]);

        Menu::create([
            'nama_menu' => 'Palm Sugar Coffee',
            'harga' => 18000,
            'kategori' => 'Coffee',
            'foto' => 'img/GulaAren.jpeg',
            'deskripsi' => "Kopi susu gula aren favorit! Espresso premium berpadu sempurna dengan kelembutan susu segar dan pemanis alami gula aren. Segar, manis, dan bikin semangat lagi.\n\n".
                            "Komposisi Utama: Espresso, Fresh Milk, Liquid Palm Sugar, Ice."
        ]);

        Menu::create([
            'nama_menu' => 'Lemon Coffee',
            'harga' => 18000,
            'kategori' => 'Coffee',
            'foto' => 'img/LemonCoffee.jpeg',
            'deskripsi' => "Kesegaran ganda dalam satu gelas. Perpaduan espresso yang kuat dengan sensasi citrus dari buah lemon asli. Minuman yang ringan, jernih, dan sangat membangkitkan mood.\n\n".
                            "Komposisi Utama: Espresso, Lemon Juice, Simple Syrup, Ice."
        ]);

        Menu::create([
            'nama_menu' => 'Peach Earl Grey',
            'harga' => 25000,
            'kategori' => 'Non-Coffee',
            'foto' => 'img/PeachEarlGreyTea.jpg',
            'deskripsi' => "Kesegaran teh Earl Grey premium dengan potongan buah dan sirup peach yang manis. Pilihan tepat bagi kamu yang menginginkan minuman teh dengan aroma bunga dan rasa buah yang berkelas.\n\n".
                            "Komposisi Utama: Earl Grey Tea, Peach Syrup, Fresh Peach, Ice."
        ]);

        Menu::create([
            'nama_menu' => 'Lemon Tea',
            'harga' => 20000,
            'kategori' => 'Non-Coffee',
            'foto' => 'img/LemonTea.jpg',
            'deskripsi' => "Teh dingin yang menyegarkan dengan sentuhan lemon alami. Perpaduan klasik yang selalu berhasil mengembalikan semangatmu.\n\n".
                            "Komposisi Utama: Black Tea, Fresh Lemon Juice, Fresh Lemon, Sugar, Ice."
        ]);

        Menu::create([
            'nama_menu' => 'Lychee Tea',
            'harga' => 20000,
            'kategori' => 'Non-Coffee',
            'foto' => 'img/LycheeTea.jpg',
            'deskripsi' => "Kesegaran teh dingin dengan aroma leci yang manis dan menenangkan. Dilengkapi dengan buah leci asli sebagai pelengkap kesegaran harimu.\n\n".
                            "Komposisi Utama: BBlack Tea, Lychee Syrup, Fresh Lychee, Ice."
        ]);

        Menu::create([
            'nama_menu' => 'Strawberry Sparkle',
            'harga' => 25000,
            'kategori' => 'Non-Coffee',
            'foto' => 'img/StrawberrySparkle.jpg',
            'deskripsi' => "Minuman soda stroberi yang dingin dan menyegarkan. Perpaduan sempurna antara manisnya buah stroberi dan sensasi sparkling yang bikin nagih. Look-nya yang cantik sangat cocok untuk foto estetikmu!\n\n".
                            "Komposisi Utama: Strawberry Syrup, Sparkling Water, Fresh Strawberry, Ice."
        ]);

        Menu::create([
            'nama_menu' => 'Cherry Sparkle',
            'harga' => 24000,
            'kategori' => 'Non-Coffee',
            'foto' => 'img/CherrySparkle.jpg',
            'deskripsi' => "Ledakan rasa ceri yang manis bertemu dengan segarnya soda dingin. Minuman berwarna merah cantik yang tidak hanya menyegarkan dahaga, tapi juga mencerahkan hari kamu.\n\n".
                            "Komposisi Utama: Red Cherry Syrup, Sparkling Water, Maraschino Cherry, Ice."
        ]);

        Menu::create([
            'nama_menu' => 'Ayam Geprek',
            'harga' => 17000,
            'kategori' => 'Makanan',
            'foto' => 'img/AyamGeprek.jpeg',
            'deskripsi' => "Ayam krispi gurih yang digeprek dengan sambal bawang asli yang pedasnya juara. Lengkap dengan nasi dan lalapan. Simple, kenyang, dan memuaskan!\n\n".
                            "Komposisi Utama: Ayam Krispi, Sambal Bawang, Nasi Putih, Timun, Selada."
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
        
        Menu::create([
            'nama_menu' => 'Red Velvet Milkshake',
            'harga' => 20000,
            'kategori' => 'promo',
            'foto' => 'img/RedVelvetMilkshake.jpg'
        ]);

        Menu::create([
            'nama_menu' => 'Hazelnut Bliss',
            'harga' => 25000,
            'kategori' => 'promo', 
            'foto' => 'img/HazelnutBliss.jpg'
        ]);

        Menu::create([
            'nama_menu' => 'Pure Matcha',
            'harga' => 26000,
            'kategori' => 'promo', 
            'foto' => 'img/PureMatcha.jpg'
        ]);
        
        Menu::create([
            'nama_menu' => 'Espresso',
            'harga' => 26000,
            'kategori' => 'promo', 
            'foto' => 'img/EspressoSolo.jpg'
        ]);

         Menu::create([
            'nama_menu' => 'Caramel Bliss',
            'harga' => 24000,
            'kategori' => 'promo', 
            'foto' => 'img/CaramelBliss.jpg'
        ]);

         Menu::create([
            'nama_menu' => 'Iced Americano',
            'harga' => 22000,
            'kategori' => 'promo', 
            'foto' => 'img/IcedAmericano.jpg'
        ]);

         Menu::create([
            'nama_menu' => 'Mango Smoothie',
            'harga' => 25000,
            'kategori' => 'promo', 
            'foto' => 'img/MangoSmoothie.jpg'
        ]);
         Menu::create([
            'nama_menu' => 'Midnight Mocha',
            'harga' => 23000,
            'kategori' => 'promo', 
            'foto' => 'img/MidnightMochaBrew.jpg'
        ]);

         Menu::create([
            'nama_menu' => 'Mocha Magic',
            'harga' => 21000,
            'kategori' => 'promo', 
            'foto' => 'img/MochaMagic.jpg'
        ]);

         Menu::create([
            'nama_menu' => 'Vanilla Velvet',
            'harga' => 26000,
            'kategori' => 'promo', 
            'foto' => 'img/VanillaVelvet.jpg'
        ]);
    }
}