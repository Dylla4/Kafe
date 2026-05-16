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
            'harga'     => 16000,
            'kategori'  => 'Coffee',
            'foto'      => 'img/Americano.jpeg',
            'deskripsi' => "Nikmati kesegaran Americano Coffee dengan cita rasa kopi hitam yang bold, smooth, dan autentik.\n\n" .
                            "Komposisi Utama: Double Shot Espresso, Water."
        ]);
        
        Menu::create([
            'nama_menu' => 'Almond Coffee',
            'harga' => 22000,
            'kategori' => 'Coffee',
            'foto' => 'img/AlmoundCoffee.jpeg',
            'deskripsi' => "Nikmati perpaduan bold dari espresso premium dan creamy-nya susu segar dengan sentuhan sirup almond yang aromatik. Disajikan dengan topping whipped cream lembut dan taburan kacang almond panggang yang renyah.\n\n" .
                            "Komposisi Utama:Espresso, Fresh Milk, Almond Syrup, Whipped Cream, Roasted Almond.",
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Biskuit Coffee',
            'harga' => 24000,
            'kategori' => 'Coffee',
            'foto' => 'img/BiskiesCoffee.jpeg',
            'deskripsi' => "Kopi susu vanila premium dengan topping whipped cream melimpah dan taburan biskuit crunchy. Cara manis untuk menikmati kopi dengan gaya modern.\n\n".
                            "Komposisi Utama: Espresso, Milk, Vanilla, Cookie Crumbs, Whipped Cream.",
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Caramel Latte',
            'harga' => 24000,
            'kategori' => 'Coffee',
            'foto' => 'img/CaramelCoffee.jpeg',
            'deskripsi' => "Kopi susu lembut dengan sensasi manis karamel yang mewah. Pilihan tepat untuk kamu yang menginginkan kopi creamy dengan aroma karamel yang memanjakan lidah.\n\n".
                            "Komposis Utama: Espresso, Fresh Milk, Premium Caramel Syrup.",
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Espresso',
            'harga' => 17000,
            'kategori' => 'Coffee', 
            'foto' => 'img/EspressoSolo.jpg',
            'deskripsi' => "Satu atau dua shot kopi hitam pekat dengan aroma yang sangat kuat dan rasa yang mendalam. Tanpa campuran susu atau gula, murni untuk kamu yang menyukai tantangan rasa kopi asli.\n\n".
                            "Komposis Utama: Espresso.",
        ]);

        Menu::create([
            'nama_menu' => 'Mocha Latte',
            'harga' => 24000,
            'kategori' => 'Coffee', 
            'foto' => 'img/MochaLatte.jpg',
            'deskripsi' => "Perpaduan pas antara kopi espresso dan cokelat premium yang manis. Disajikan dengan susu segar untuk rasa yang lebih smooth. Pilihan favorit untuk menemani hari yang santai.\n\n".
                            "Komposis Utama: Espresso, Chocolate Sauce, Steamed Milk, Foam.",
        ]);

        Menu::create([
            'nama_menu' => 'Coffee Latte',
            'harga' => 21000,
            'kategori' => 'Coffee',
            'foto' => 'img/CoffeLattee.jpeg',
            'deskripsi' => "Nikmati harmoni rasa espresso pilihan dan kelembutan susu segar. Teksturnya yang creamy dan rasanya yang halus menjadikan minuman ini teman terbaik untuk segala suasana.\n\n".
                            "Komposisi Utama: Espresso, Steamed Milk, Micro-foam."
        ]);

        Menu::create([
            'nama_menu' => 'Dalgona Coffee',
            'harga' => 23000,
            'kategori' => 'Coffee',
            'foto' => 'img/Dalgona.jpeg',
            'deskripsi' => "Perpaduan estetik dari susu segar dingin dan busa kopi kental yang manis di atasnya. Cara seru dan creamy untuk menikmati kopi dingin yang sedang tren.\n\n".
                            "Komposisi Utama: Coffee Foam, Fresh Milk, Ice, Brown Sugar."
        ]);

        Menu::create([
            'nama_menu' => 'Palm Sugar Coffee',
            'harga' => 22000,
            'kategori' => 'Coffee',
            'foto' => 'img/GulaAren.jpeg',
            'deskripsi' => "Kopi susu gula aren favorit! Espresso premium berpadu sempurna dengan kelembutan susu segar dan pemanis alami gula aren. Segar, manis, dan bikin semangat lagi.\n\n".
                            "Komposisi Utama: Espresso, Fresh Milk, Liquid Palm Sugar, Ice."
        ]);

        Menu::create([
            'nama_menu' => 'Cappucino',
            'harga' => 20000,
            'kategori' => 'Coffee',
            'foto' => 'img/Cappucino.jpg',
            'deskripsi' => "Minuman kopi klasik dengan komposisi seimbang antara espresso, susu panas, dan busa susu yang tebal. Nikmati sensasi rasa kopi yang mantap dengan sentuhan kelembutan di setiap tegukannya.\n\n".
                            "Komposisi Utama: Espresso, Steamed Milk, Milk Foam."
        ]);

        Menu::create([
            'nama_menu' => 'Hazelnut Bliss',
            'harga' => 24000,
            'kategori' => 'Coffee',
            'foto' => 'img/HazelnutBliss.jpg',
            'deskripsi' => "Kopi susu dengan aroma hazelnut yang memikat dan rasa gurih yang lembut. Perpaduan pas untuk kamu yang menyukai kopi dengan sentuhan rasa kacang yang manis dan menenangkan.\n\n".
                            "Komposisi Utama: Espresso, Fresh Milk, Hazelnut Syrup, Ice."
        ]);

        Menu::create([
            'nama_menu' => 'Lemon Coffee',
            'harga' => 21000,
            'kategori' => 'Coffee',
            'foto' => 'img/LemonCoffee.jpeg',
            'deskripsi' => "Kesegaran ganda dalam satu gelas. Perpaduan espresso yang kuat dengan sensasi citrus dari buah lemon asli. Minuman yang ringan, jernih, dan sangat membangkitkan mood.\n\n".
                            "Komposisi Utama: Espresso, Lemon Juice, Simple Syrup, Ice."
        ]);

        Menu::create([
            'nama_menu' => 'Caramel Macchiato',
            'harga' => 24000,
            'kategori' => 'Coffee',
            'foto' => 'img/CaramelMacchiato.jpg',
            'deskripsi' => "Kopi susu populer dengan tiga lapisan rasa: manisnya vanila, kuatnya espresso, dan lezatnya saus karamel di bagian atas. Pilihan tepat untuk kamu yang ingin kopi dengan sensasi manis yang berkelas.\n\n".
                            "Komposisi Utama: Espresso, Fresh Milk, Vanilla Syrup, Caramel Drizzle, Ice."
        ]);

        Menu::create([
            'nama_menu' => 'Flat White',
            'harga' => 22000,
            'kategori' => 'Coffee',
            'foto' => 'img/FlatWhite.jpg',
            'deskripsi' => "Kopi susu dengan tekstur yang lebih halus dan rasa espresso yang lebih kuat dibandingkan Latte. Menggunakan micro-foam tipis untuk memberikan sensasi minum kopi yang lebih bold namun tetap lembut di lidah.\n\n".
                            "Komposisi Utama: Double Espresso, Silky Steamed Milk, Thin Micro-foam."
        ]);

        Menu::create([
            'nama_menu' => 'Piccolo Latte',
            'harga' => 21000,
            'kategori' => 'Coffee',
            'foto' => 'img/PiccoloLatte.jpg',
            'deskripsi' => "Versi ringkas dari Latte dengan rasa kopi yang lebih dominan. Menggunakan ristretto shot dan sedikit susu untuk kamu yang menyukai kelembutan tanpa menutupi karakter asli biji kopi.\n\n".
                            "Komposisi Utama: Ristretto, Warm Milk, Light Foam."
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
            'nama_menu' => 'Hot Chocolate',
            'harga' => 22000,
            'kategori' => 'Non-Coffee',
            'foto' => 'img/ChocolateHot.jpeg',
            'deskripsi' => "Nikmati kelembutan cokelat premium yang creamy dan silky. Minuman klasik yang tak lekang oleh waktu, cocok untuk kamu yang menginginkan ketenangan di tengah hari yang sibuk.\n\n".
                            "Komposisi Utama: Premium Cocoa Blend, Steamed Milk, Foam."
        ]);

        Menu::create([
            'nama_menu' => 'Strawberry Milkshake',
            'harga' => 29000,
            'kategori' => 'Non-Coffee',
            'foto' => 'img/StrawberryMilkshake.jpg',
            'deskripsi' => "Manjakan dirimu dengan kelembutan susu segar dan ekstrak stroberi premium yang di-blend sempurna. Minuman manis yang dingin dan mengenyangkan, lengkap dengan whipped cream di atasnya.\n\n".
                            "Komposisi Utama: Strawberry, Fresh Milk, Vanilla Ice Cream, Whipped Cream."
        ]);

        Menu::create([
            'nama_menu' => 'Peach Earl Grey',
            'harga' => 23000,
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
            'harga' => 24000,
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
            'harga' => 26000,
            'kategori' => 'Non-Coffee',
            'foto' => 'img/CherrySparkle.jpg',
            'deskripsi' => "Ledakan rasa ceri yang manis bertemu dengan segarnya soda dingin. Minuman berwarna merah cantik yang tidak hanya menyegarkan dahaga, tapi juga mencerahkan hari kamu.\n\n".
                            "Komposisi Utama: Red Cherry Syrup, Sparkling Water, Maraschino Cherry, Ice."
        ]);

        Menu::create([
            'nama_menu' => 'Red Velvet Milkshake',
            'harga' => 27000,
            'kategori' => 'Non-Coffee',
            'foto' => 'img/RedVelvetMilkshake.jpg',
            'deskripsi' => "Sensasi minum kue Red Velvet yang dingin dan creamy. Perpaduan pas antara rasa cokelat khas, susu segar, dan es krim vanila yang lembut. Mood booster yang sempurna untuk hari-harimu!\n\n".
                            "Komposisi Utama: Red Velvet Base, Vanilla Ice Cream, Fresh Milk, Whipped Cream."
        ]);

        Menu::create([
            'nama_menu' => 'Pure Matcha',
            'harga' => 17000,
            'kategori' => 'Non-Coffee', 
            'foto' => 'img/PureMatcha.jpg',
            'deskripsi' => "Perpaduan bubuk matcha murni berkualitas tinggi dengan susu segar yang lembut. Menghasilkan rasa teh hijau yang kuat dan autentik dengan tekstur yang creamy.\n\n".
                            "Komposisi Utama: Premium Matcha Powder and Fresh Milk."
        ]);

        Menu::create([
            'nama_menu' => 'Mango Smoothie',
            'harga' => 26000,
            'kategori' => 'Non-Coffee', 
            'foto' => 'img/MangoSmoothie.jpg',
            'deskripsi' => "Hadirkan suasana musim panas dalam satu gelas! Dibuat dari buah mangga pilihan yang matang sempurna, diblender halus dengan susu rendah lemak atau yogurt untuk menghasilkan tekstur yang sangat creamy dan kental.\n\n".
                            "Komposisi Utama: Real Mango Fruit, Fresh Milk/Yogurt, Ice."
        ]);

        Menu::create([
            'nama_menu' => 'Avocado Smoothie',
            'harga' => 28000,
            'kategori' => 'Non-Coffee', 
            'foto' => 'img/AvocadoSmoothie.jpg',
            'deskripsi' => "Nikmati kelembutan buah alpukat mentega pilihan yang dipadukan dengan susu segar untuk menciptakan tekstur smoothie yang sangat kental dan velvety.\n\n".
                            "Komposisi Utama: Alpukat Mentega, Fresh Milk, Ice."
        ]);

        Menu::create([
            'nama_menu' => 'Taro Boba Milk',
            'harga' => 20000,
            'kategori' => 'Non-Coffee', 
            'foto' => 'img/TaroBobaMilk.jpg',
            'deskripsi' => "Manjakan lidahmu dengan kelezatan rasa talas ungu (taro) yang manis dan memiliki aroma nutty yang khas dengan topping boba yang kenyal di setiap sesapan.\n\n".
                            "Komposisi Utama: Premium Taro Powder, Fresh Milk, Brown Sugar Boba."
        ]);

        Menu::create([
            'nama_menu' => 'Raspberry Frappe',
            'harga' => 28000,
            'kategori' => 'Non-Coffee', 
            'foto' => 'img/RaspberryFrappe.jpg',
            'deskripsi' => "Minuman es blender rasa buah raspberry yang segar dan manis. Pilihan tepat bagi kamu yang menyukai sensasi buah beri yang dingin dan ringan di lidah.\n\n".
                            "Komposisi Utama: Raspberry Puree/Sirup, Milk Base, Blended Ice, Whipped Cream."
        ]);

        Menu::create([
            'nama_menu' => 'Blueberry Frappe',
            'harga' => 29000,
            'kategori' => 'Non-Coffee', 
            'foto' => 'img/BlueberryFrappe.jpg',
            'deskripsi' => "Minuman es blender dengan rasa blueberry yang kaya dan menyegarkan. Perpaduan pas antara buah beri dan susu untuk menemani waktu santaimu.\n\n".
                            "Komposisi Utama: Blueberry Puree, Milk Base, Blended Ice, Whipped Cream."
        ]);
        
        Menu::create([
            'nama_menu' => 'Dimsum Mentai',
            'harga' => 35000,
            'kategori' => 'Makanan',
            'foto' => 'img/DimsumMentai.jpeg',
            'deskripsi' => "Dimsum ayam lembut dengan siraman saus mentai yang ditorched. Perpaduan rasa gurih, pedas, dan aroma smoky yang bikin ketagihan.\n\n".
                            "Komposisi Utama: Chicken Dimsum, Special Mentai Sauce, Nori, Sesame Seeds, Chili Oil."
        ]);

        Menu::create([
            'nama_menu' => 'Gimbap',
            'harga' => 40000,
            'kategori' => 'Makanan',
            'foto' => 'img/Gimbap.jpeg',
            'deskripsi' => "Gulungan nasi rumput laut khas Korea dengan isian sayuran segar dan protein pilihan. Potongannya yang pas di mulut menjadikannya camilan berat favorit yang mengenyangkan.\n\n".
                            "Komposisi Utama: Nasi Wijen, Nori, Wortel, Timun, Telur, Danmuji (Acar Lobak), Ayam"
        ]);

        Menu::create([
            'nama_menu' => 'Nugget Ayam',
            'harga' => 25000,
            'kategori' => 'Makanan',
            'foto' => 'img/Naget.jpeg',
            'deskripsi' => "Nugget ayam goreng yang renyah dan gurih, disajikan hangat dengan saus cocolan favoritmu. Teman ngemil paling asyik sambil minum kopi atau smoothie.\n\n".
                            "Komposisi Utama: Daging Ayam Premium, Tepung Roti, Saus Sambal, Mayones."
        ]);

        Menu::create([
            'nama_menu' => 'Onigiri',
            'harga' => 40000,
            'kategori' => 'Makanan',
            'foto' => 'img/Onigiri.jpeg',
            'deskripsi' => "Nasi kepal segitiga dengan isian favorit dan balutan nori yang garing. Pilihan camilan sehat dan praktis untuk mengganjal lapar di tengah kesibukanmu.\n\n".
                            "Komposisi Utama: Nasi Jepang (Wijen), Nori, Tuna Mayo"
        ]);

        Menu::create([
            'nama_menu' => 'Sushi Salmon',
            'harga' => 111000,
            'kategori' => 'Makanan',
            'foto' => 'img/Salmon.jpeg',
            'deskripsi' => "Perpaduan nasi sushi otentik dengan ikan salmon segar. Camilan sehat dan berkelas yang cocok dinikmati kapan saja.\n\n".
                            "Komposisi Utama: Salmon Premium, Nasi Sushi, Kecap Asin, Wasabi.",
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Hamburger Ayam',
            'harga' => 30000,
            'kategori' => 'Makanan',
            'foto' => 'img/Burgerayaam.jpeg',
            'deskripsi' => "Burger ayam dengan patty yang lembut, sayuran segar, dan saus spesial dalam balutan roti bun panggang.\n\n".
                            "Komposisi Utama: Chicken Patty, Soft Bun, Cheese Slice, Fresh Lettuce, Tomato, Special Sauce."
        ]);

        Menu::create([
            'nama_menu' => 'Hamburger Beef',
            'harga' => 35000,
            'kategori' => 'Makanan',
            'foto' => 'img/Burgerbeef.jpeg',
            'deskripsi' => "Burger dengan daging sapi asli yang tebal dan juicy, sayuran segar, dan saus spesial yang gurih.\n\n".
                            "Komposisi Utama: Beef Patty, Soft Bun, Cheese Slice, Tomato, Fresh Lettuce, Special Sauce."
        ]);

        Menu::create([
            'nama_menu' => 'Cheese Rabokki',
            'harga' => 27000,
            'kategori' => 'Makanan',
            'foto' => 'img/CheeseRabokki.jpg',
            'deskripsi' => "Nikmati perpaduan sempurna antara mie ramen yang kenyal dan tteokbokki (kue beras) yang lembut, dimasak dalam saus keju pedas.\n\n".
                            "Komposisi Utama: Ramen, Tteok (Kue Beras), Odeng (Fish Cake), Gochujang Sauce, Mozzarella Cheese."
        ]);

        Menu::create([
            'nama_menu' => 'French Fries',
            'harga' => 15000,
            'kategori' => 'Makanan',
            'foto' => 'img/KentangGoreng.jpeg',
            'deskripsi' => "Nikmati potongan kentang pilihan yang digoreng hingga mencapai tingkat kerenyahan sempurna dengan warna keemasan yang menggoda.\n\n".
                            "Komposisi Utama: Premium Potato Fries, Sea Salt, Saus Sambal dan Tomat."
        ]);

        Menu::create([
            'nama_menu' => 'Lumpia',
            'harga' => 20000,
            'kategori' => 'Makanan',
            'foto' => 'img/Lumpiah.jpeg',
            'deskripsi' => "Nikmati kelezatan camilan klasik berupa gulungan kulit krispi yang diisi dengan perpaduan rebung muda, wortel, dan daging ayam yang ditumis gurih dengan bumbu rempah pilihan.\n\n".
                            "Komposisi Utama: Kulit Lumpia, Ayam, Rebung, Sayuran, Saus Spesial."
        ]);

        Menu::create([
            'nama_menu' => 'Sosis Bakar',
            'harga' => 18000,
            'kategori' => 'Makanan',
            'foto' => 'img/sosisbakar.jpeg',
            'deskripsi' => "Nikmati sosis sapi jumbo berkualitas premium yang dipanggang dengan olesan saus BBQ rahasia hingga meresap sempurna.\n\n".
                            "Komposisi Utama: Sosis Sapi Premium, Saus BBQ, Mayones, Saus Sambal."
        ]);

        Menu::create([
            'nama_menu' => 'Gyoza',
            'harga' => 25000,
            'kategori' => 'Makanan',
            'foto' => 'img/Gyoza.jpg',
            'deskripsi' => "Nikmati kelezatan pangsit khas Jepang dengan isian daging ayam cincang dan sayuran segar yang dibumbui rempah jahe dan bawang putih yang aromatik.\n\n".
                            "Komposisi Utama: Daging Ayam, Daun Bawang, Jahe, Kulit Gyoza, Chili Oil."
        ]);

        Menu::create([
            'nama_menu' => 'Tteokbokki',
            'harga' => 27000,
            'kategori' => 'Makanan',
            'foto' => 'img///Tteokbokki.jpg',
            'deskripsi' => "Nikmati sensasi kuliner jalanan Korea yang otentik dengan kue beras (tteok) yang kenyal sempurna, dimasak dalam saus gochujang merah yang kental dengan perpaduan rasa pedas dan manis yang seimbang.\n\n".
                            "Komposisi Utama: Tteok (Kue Beras), Odeng (Fish Cake), Gochujang Sauce, Telur Rebus, Wijen."
        ]);

        Menu::create([
            'nama_menu' => 'Kebab',
            'harga' => 28000,
            'kategori' => 'Makanan',
            'foto' => 'img/KebabBeef.jpg',
            'deskripsi' => "Nikmati perpaduan irisan daging sapi premium yang dibumbui rempah khas Timur Tengah, dipanggang perlahan hingga juicy dan aromatik yang dengan kulit tortilla yang lembut dan dipanggang krispi.\n\n".
                            "Komposisi Utama: Beef Slices, Tortilla, Lettuce, Tomato, Onion, Special Sauce."
        ]);

        Menu::create([
            'nama_menu' => 'Rujak Cireng',
            'harga' => 16000,
            'kategori' => 'Makanan',
            'foto' => 'img/RujakCireng.jpg',
            'deskripsi' => "Nikmati camilan tradisional khas Jawa Barat yang terbuat dari tepung tapioka berkualitas, digoreng hingga menghasilkan tekstur luar yang sangat renyah namun tetap kenyal dan lembut di dalam.\n\n".
                            "Komposisi Utama: Tapioka Pilihan, Rempah Bawang, Sambal Rujak (Gula Merah & Cabai)."
        ]);

        Menu::create([
            'nama_menu' => 'Chocolate Cake',
            'harga' => 20000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/ChocolateCake.jpeg',
            'deskripsi' => "Manjakan diri kamu dengan sepotong kue cokelat premium yang memiliki tekstur super lembut. Dilapisi cokelat hitam yang kaya dan tidak terlalu manis, memberikan sensasi rasa cokelat kuat di setiap gigitan.\n\n".
                            "Komposisi Utama: Dark Chocolate Premium, Cocoa Powder, Fresh Cream, Moist Sponge Cake.",
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Original Churros',
            'harga' => 25000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/Churros.jpeg',
            'deskripsi' => "Nikmati camilan khas Spanyol yang digoreng hingga garing keemasan di luar, namun tetap lembut di dalam. Setiap batang churros ditaburi dengan perpaduan gula halus dan bubuk kayu manis yang aromatik.\n\n".
                            "Komposisi Utama: Tepung Pilihan, Bubuk Kayu Manis, Gula Halus, Saus Cokelat."
        ]);

        Menu::create([
            'nama_menu' => 'Original Croissant',
            'harga' => 23000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/Croissant.jpeg',
            'deskripsi' => "Pastri berlapis yang renyah di luar dan lembut di dalam serta aroma harum dan rasa gurih butter yang kaya di setiap gigitannya.\n\n".
                            "Komposisi Utama: Tepung Pastri Premium, Mentega Pilihan, Ragi."
        ]);

        Menu::create([
            'nama_menu' => 'Almond Croissant',
            'harga' => 28000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/CroissantAlmond.jpeg',
            'deskripsi' => "Nikmati perpaduan sempurna antara pastri mentega yang renyah dengan isian almond cream (frangipane) yang manis dan lembut di dalamnya. Dtaburi dengan irisan kacang almond dan sentuhan gula halus.\n\n".
                            "Komposisi Utama: Mentega Premium, Isian Krim Almond, Irisan Almond, Gula Halus."
        ]);

        Menu::create([
            'nama_menu' => 'Chocolate Croissant',
            'harga' => 27000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/Croissantcoklat.jpeg',
            'deskripsi' => "Nikmati keajaiban pastri khas Prancis yang berlapis-lapis dan renyah dengan isian dark chocolate premium di dalamnya.\n\n".
                            "Komposisi Utama: Mentega Premium, Dark Chocolate Batons, Gula Halus."
        ]);

        Menu::create([
            'nama_menu' => 'Pisang Keju Coklat',
            'harga' => 18000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/pisang.jpg',
            'deskripsi' => "Nikmati kelezatan pisang pilihan yang digoreng hingga keemasan, menghasilkan tekstur yang lembut dan manis dengan topping keju parut dan cokelat melimpah.\n\n".
                            "Komposisi Utama: Pisang Kepok/Raja, Keju Cheddar, Meses Cokelat, Susu Kental Manis.",
        ]);

        Menu::create([
            'nama_menu' => 'Lemon Cheesecake',
            'harga' => 23000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/LemonCheesecake.jpg',
            'deskripsi' => "Nikmati perpaduan sempurna antara cream cheese premium yang lembut dengan sentuhan kesegaran sari lemon di atas lapisan biskuit mentega yang renyah.\n\n".
                            "Komposisi Utama: Cream Cheese, Fresh Lemon Zest, Butter Cracker Crust, Whipped Cream.",
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Oreo Cheesecake',
            'harga' => 25000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/OreoCheesecake.jpg',
            'deskripsi' => "Rasakan perpaduan sempurna antara kelembutan cream cheese premium dengan potongan biskuit Oreo yang melimpah di atas lapisan biskuit cokelat yang renyah.\n\n".
                            "Komposisi Utama: Cream Cheese, Oreo Cookies, Butter, Whipped Cream."
        ]);

        Menu::create([
            'nama_menu' => 'Strawberry Cheesecake',
            'harga' => 26000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/StrawberryCheesecake.jpg',
            'deskripsi' => "Manjakan diri dengan kelembutan cream cheese premium yang dipadukan dengan selai strawberry buatan sendiri yang segar di atas lapisan biskuit mentega yang renyah.\n\n".
                            "Komposisi Utama: Cream Cheese, Fresh Strawberries, Strawberry Glaze, Graham Cracker Crust.",
            'is_best_seller' => true
        ]);

        Menu::create([
            'nama_menu' => 'Brownie Sundae Bliss',
            'harga' => 35000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/BrownieSundaeBliss.jpg',
            'deskripsi' => "Nikmati puncak kelezatan cokelat dalam satu mangkuk. Potongan fudgy brownie yang hangat dan kaya rasa cokelat hitam, disajikan dengan dua scoop es krim vanilla yang lembut dan dingin.\n\n".
                            "Komposisi Utama: Warm Fudgy Brownie, Vanilla Ice Cream, Chocolate Lava Sauce, Roasted Peanuts, Whipped Cream."
        ]);

        Menu::create([
            'nama_menu' => 'Raspberry Mousse',
            'harga' => 34000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/RaspberryMousse.jpg',
            'deskripsi' => "Nikmati sensasi lembut dan ringan dari mousse raspberry yang dibuat dari buah raspberry segar pilihan yang memberikan keseimbangan antara rasa manis dan asam yang menyegarkan di setiap suapan.\n\n".
                            "Komposisi Utama: Raspberry Puree, Fresh Cream, Sugar, Egg Whites (Meringue), Mint Leaf.",
            'is_best_seller' => true
        ]);
        
        Menu::create([
            'nama_menu' => 'Blueberry Mousse',
            'harga' => 36000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/BlueberryMousse.jpg',
            'deskripsi' => "Manjakan lidah dengan mousse blueberry yang dibuat dari perpaduan buah blueberry asli dan krim segar pilihan yang menawarkan keseimbangan rasa manis dan sedikit asam di setiap suapan.\n\n".
                            "Komposisi Utama: Blueberry Puree, Fresh Cream, Sugar, Fresh Blueberries."
        ]);

        Menu::create([
            'nama_menu' => 'Chocolate Puding',
            'harga' => 29000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/ChocolatePuding.jpg',
            'deskripsi' => "Nikmati kelembutan puding cokelat yang dibuat dengan bubuk cokelat premium, menghasilkan tekstur yang sangat lembut. Disajikan dingin dengan siraman saus vanilla yang creamy dan kental.\n\n".
                            "Komposisi Utama: Dark Chocolate Powder, Fresh Milk, Sugar, Vanilla VLA Sauce."
        ]);

        Menu::create([
            'nama_menu' => 'Caramel Puding',
            'harga' => 22000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/CaramelPuding.jpg',
            'deskripsi' => "Nikmati kelembutan puding yang memiliki tekstur lumer di mulut. Disajikan dengan siraman saus karamel emas yang manis.\n\n".
                            "Komposisi Utama: Telur Pilihan, Susu Segar, Gula Karamel, Vanilla."
        ]);

        Menu::create([
            'nama_menu' => 'Panna Cotta',
            'harga' => 32000,
            'kategori' => 'Sweet Treats',
            'foto' => 'img/MiniCake.jpg',
            'deskripsi' => "Rasakan kelembutan puding krim khas Italia yang dibuat dari krim segar dan vanilla pilihan, menghasilkan tekstur yang lumer di mulut.\n\n".
                            "Komposisi Utama: Fresh Cream, Vanilla, Sugar, Mixed Berries."
        ]);
    }
}