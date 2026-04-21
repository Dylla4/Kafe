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
                <a href="{{ route('ulasan.create') }}" 
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
                <p class="text-[10px] opacity-50 mb-4 font-bold uppercase tracking-widest">Click Here:</p>
                <div class="flex gap-5">
                    <a href="https://wa.me/6281234567890" target="_blank" class="hover:scale-110 transition opacity-80 hover:opacity-100">
                        <svg class="w-7 h-7 fill-[#FDFBF7]" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </a>

                    <a href="https://instagram.com/valeriacoffee" target="_blank" class="hover:scale-110 transition opacity-80 hover:opacity-100">
                        <svg class="w-7 h-7 fill-[#FDFBF7]" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.17.054 1.805.249 2.227.412.56.216.96.475 1.382.897.422.422.681.822.897 1.382.164.422.359 1.057.412 2.227.059 1.266.071 1.646.071 4.85s-.012 3.584-.071 4.85c-.054 1.17-.249 1.805-.412 2.227-.216.56-.475.96-.897 1.382-.422.422-.822.681-1.382.897-.422.164-1.057.359-2.227.412-1.266.059-1.646.071-4.85.071s-3.584-.012-4.85-.071c-1.17-.054-1.805-.249-2.227-.412-.56-.216-.96-.475-1.382-.897-.422-.422-.822-.897-1.382-.897-.422.164-1.057.359-2.227-.412-1.266-.059-1.646-.071-4.85-.071s.012-3.584.071-4.85c.054-1.17.249-1.805.412-2.227.216-.56.475-.96.897-1.382.422-.422.822-.681 1.382-.897.422-.164 1.057-.359 2.227-.412 1.266-.059 1.646-.071 4.85-.071zM12 0C8.741 0 8.333.014 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.132 5.775.072 7.053.014 8.333 0 8.741 0 12s.014 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126s1.355 1.078 2.144 1.384c.766.296 1.636.499 2.913.558C8.333 23.986 8.741 24 12 24s3.667-.014 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384s1.078-1.354 1.384-2.143c.296-.766.499-1.636.558-2.913.058-1.28.072-1.687.072-4.947s-.014-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126s-1.354-1.078-2.143-1.384c-.766-.296-1.636-.499-2.913-.558C15.667.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </a>
                </div>
            </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>