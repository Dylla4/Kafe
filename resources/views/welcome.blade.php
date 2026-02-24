<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nikmati Kopi Terbaik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 text-stone-800">

    <nav class="bg-white/90 backdrop-blur-sm shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-orange-700">☕ Jalii Coffee</h1>
            <div class="flex items-center space-x-6">
                <div class="space-x-6 hidden md:flex font-medium">
                    <a href="#" class="hover:text-orange-600">Home</a>
                    <a href="#menu" class="hover:text-orange-600">Menu</a>
                    <a href="#lokasi" class="hover:text-orange-600">Lokasi</a>
                </div>
                <a href="{{ url('/cart') }}" class="bg-orange-700 text-white px-6 py-2 rounded-full font-bold hover:bg-orange-700 transition shadow-xl">
                    <span>🛒</span> Lihat Keranjang
                </a>
            </div>
        </div>
    </nav>

    <header class="relative h-screen flex items-center justify-center text-center text-white overflow-hidden">
    <img src="img/kopi.jpg" 
         class="absolute inset-0 w-full h-full object-cover brightness-50" 
         alt="Kafe Kita Background">
    
    <div class="relative z-10 px-4">
        <h2 class="text-5xl md:text-7xl font-extrabold mb-4 drop-shadow-2xl">
            Awali Harimu dengan Kopi
        </h2>
        <p class="text-xl md:text-2xl mb-8 text-stone-200 drop-shadow-md">
            Dibuat dengan biji pilihan oleh barista berpengalaman.
        </p>
        <a href="#menu" class="bg-orange-700 text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-orange-800 transition shadow-xl">
            Lihat Menu Spesial
        </a>
    </div>
    </header>

    <section id="menu" class="max-w-6xl mx-auto py-20 px-4">
    <h2 class="text-3xl font-bold text-center mb-12">Menu Spesial Kami</h2>
        
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    @foreach($menus as $m)
    <div class="bg-white rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden border border-stone-100 group">
        
        <div class="relative w-full h-56 overflow-hidden bg-stone-200">
            <img src="{{ asset($m->foto) }}" 
                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition duration-500" 
                 alt="{{ $m->nama_menu }}">
        </div>

        <div class="p-6">
            <span class="text-xs font-bold uppercase tracking-widest text-orange-500">{{ $m->kategori }}</span>
            <h3 class="text-xl font-bold mt-1">{{ $m->nama_menu }}</h3>
            <p class="text-2xl font-black text-stone-900 mt-3">Rp {{ number_format($m->harga) }}</p>
            
            <form action="{{ route('cart.add', $m->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full mt-6 bg-stone-800 text-white py-3 rounded-xl hover:bg-orange-700 transition font-bold">
                    + Tambah ke Pesanan
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

    </section>
    <footer id="lokasi" class="bg-stone-900 text-stone-400 py-16 px-4 mt-10">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12">
            <div>
                <h3 class="text-white text-2xl font-bold mb-4">Kontak Kami</h3>
                <p class="text-lg">Jl. Kopi Nikmat No. 123, Kota Anda</p>
                <p class="mt-2 text-orange-500 font-medium tracking-wide">Buka: 08:00 - 22:00</p>
            </div>
            <div class="md:text-right">
                <h3 class="text-white text-2xl font-bold mb-4">Project IoT 2025</h3>
                <p class="text-lg">Dashboard Terintegrasi dengan Sistem Kafe Pintar.</p>
            </div>
        </div>
    </footer>
</body>
</html>