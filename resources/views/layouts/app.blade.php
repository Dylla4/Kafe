<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valeria Coffee - Quality Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FDFBF7; }
        .bg-coffee-dark { background-color: #3C2A21; }
        .bg-coffee-medium { background-color: #5F4339; }
        .bg-coffee-light { background-color: #A06040; }
        .text-coffee { color: #3C2A21; }
        .border-coffee { border-color: #5F4339; }
    </style>
</head>

<body class="bg-white text-gray-900 flex flex-col min-h-screen">

    <nav class="border-b border-stone-200 sticky top-0 z-50 bg-white/95 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-extrabold text-[#3C2A21] tracking-tighter uppercase">
                Valeria<span class="text-[#A06040]">Coffee</span>
            </a>
            
            <div class="hidden md:flex gap-10 text-xs font-bold uppercase tracking-widest">
                <a href="{{ route('home') }}" 
                   class="{{ request()->is('/') ? 'text-[#A06040] border-b-2 border-[#A06040]' : 'text-stone-400' }} pb-1 hover:text-[#3C2A21] transition">Home</a>
                <a href="{{ route('tentang') }}" 
                   class="{{ request()->is('tentang') ? 'text-[#A06040] border-b-2 border-[#A06040]' : 'text-stone-400' }} pb-1 hover:text-[#3C2A21] transition">About Us</a>
                <a href="{{ route('menu') }}" 
                   class="{{ request()->is('menu') ? 'text-[#A06040] border-b-2 border-[#A06040]' : 'text-stone-400' }} pb-1 hover:text-[#3C2A21] transition">Our Menu</a>
                <a href="{{ route('ulasan.index') }}" 
                   class="{{ request()->is('ulasan') ? 'text-[#A06040] border-b-2 border-[#A06040]' : 'text-stone-400' }} pb-1 hover:text-[#3C2A21] transition">Review</a>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('order.history') }}" class="relative p-2 group" title="Riwayat Pesanan">
                        <span class="text-2xl">📜</span>
                    </a>

                    <a href="{{ route('cart.show') }}" class="relative p-2 group" title="Keranjang">
                        <span class="text-2xl">🛒</span> 
                        @php
                            $cart = session('cart', []);
                            $totalQty = 0;
                            foreach($cart as $item) {
                                $totalQty += $item['quantity'] ?? $item['qty'] ?? 0;
                            }
                        @endphp
                        @if($totalQty > 0)
                            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow-md animate-bounce">
                                {{ $totalQty }}
                            </span>
                        @endif
                    </a>

                    <form action="{{ route('customer.logout') }}" method="POST" class="inline pl-4 border-l border-stone-200">
                        @csrf
                        <button type="submit" class="text-xs font-extrabold uppercase tracking-widest text-red-600 hover:text-red-700 transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-extrabold uppercase tracking-widest text-stone-400 hover:text-[#3C2A21] transition">
                        Login
                    </a>
                    <a href="{{ route('customer.register') }}" class="bg-[#3C2A21] text-white text-[10px] font-bold uppercase tracking-[0.2em] px-5 py-3 rounded-full hover:bg-[#2A1D17] transition shadow-lg shadow-stone-200">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="grow">
        @yield('content')
    </main>

    <footer id="kontak" class="bg-[#1A120B] text-[#FDFBF7] pt-16 pb-8 px-6 mt-20">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16 pt-8">
                <div class="col-span-1">
                    <h2 class="text-3xl font-black tracking-tighter mb-4 uppercase">Valeria<span class="text-[#A06040]">Coffee</span></h2>
                    <p class="text-xs opacity-60 leading-relaxed mb-6">
                        ©2026 valeriacoffee.id. <br>ALL RIGHTS RESERVED.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-xs uppercase tracking-[0.2em] text-[#A06040] mb-6">Products</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li><a href="{{ route('menu') }}" class="hover:text-[#A06040] transition">Minuman Series</a></li>
                        <li><a href="{{ route('menu') }}" class="hover:text-[#A06040] transition">Makanan Series</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-xs uppercase tracking-[0.2em] text-[#A06040] mb-6">Informations</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li><a href="{{ route('tentang') }}" class="hover:text-[#A06040] transition">About Us</a></li>
                        <li><a href="{{ route('menu') }}" class="hover:text-[#A06040] transition">Menu</a></li>
                        <li class="flex items-center gap-2">📍 Bandung, Indonesia</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-2xl mb-6 text-[#FDFBF7]">Contact Us</h4>
                    <div class="flex gap-5">
                        </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>