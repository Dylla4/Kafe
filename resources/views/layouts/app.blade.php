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

    <footer class="bg-[#f8f9fa] pt-20 pb-10 border-t border-stone-200">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">
                
                {{-- Kolom 1: Logo & Info Perusahaan --}}
                <div class="flex flex-col space-y-6">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold tracking-tighter text-[#070707]">VALERIA<span class="text-[#693d04]">COFFEE</span></span>
                    </div>
                    <div class="text-stone-500 text-sm leading-relaxed">
                        © 2026 Valeria Coffee. All rights reserved.
                        <div class="mt-2 space-x-4">
                            <a href="#" class="hover:text-[#004d31] transition-colors">Terms and Conditions</a>
                            <span>•</span>
                            <a href="#" class="hover:text-[#004d31] transition-colors">Privacy Policy</a>
                        </div>
                    </div>
                </div>

                {{-- Kolom 2: Customer Center --}}
                <div class="space-y-6">
                    <h4 class="text-[#693d04] font-bold text-lg">Customer Center</h4>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-[#004d31] mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <p class="text-stone-600 text-sm">
                                Thamrin Plaza. Jl. M.H. Thamrin Kav. 8-9<br>
                                Lt. PH. Kebon Melati, Tanah Abang,<br>
                                Jakarta Pusat
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-[#004d31]" fill="currentColor" viewBox="0 0 24 24"><path d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984a9.964 9.964 0 001.333 4.993L2 22l5.233-1.237a9.921 9.921 0 004.779 1.237h.004c5.505 0 9.988-4.478 9.989-9.984 0-2.669-1.037-5.176-2.922-7.062A9.925 9.925 0 0012.012 2z"/></svg>
                            <p class="text-stone-600 text-sm font-medium">0812-1111-8456</p>
                        </div>
                    </div>
                </div>

                {{-- Kolom 3: Pengaduan Konsumen & Sosmed --}}
                <div class="space-y-6">
                    <h4 class="text-[#693d04] font-bold text-lg leading-snug">
                        Informasi Kontak Layanan<br>Pengaduan Konsumen
                    </h4>
                    <div class="text-stone-500 text-sm space-y-4">
                        <p>
                            Direktorat Jenderal Perlindungan Konsumen dan Tertib Niaga, 
                            Kementerian Perdagangan Republik Indonesia
                        </p>
                        <p class="font-medium text-[#004d31]">WhatsApp Ditjen PKTN: 0853-1111-1010</p>
                    </div>
                    
                    {{-- Social Media Icons --}}
                    <div class="flex gap-4 pt-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-stone-200 flex items-center justify-center text-stone-600 hover:bg-[#004d31] hover:text-white transition-all">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-stone-200 flex items-center justify-center text-stone-600 hover:bg-[#004d31] hover:text-white transition-all">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-stone-200 flex items-center justify-center text-stone-600 hover:bg-[#004d31] hover:text-white transition-all">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-stone-200 flex items-center justify-center text-stone-600 hover:bg-[#004d31] hover:text-white transition-all">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- Floating WhatsApp Button (Opsional seperti di gambar) --}}
    <a href="https://wa.me/081211118456" class="fixed bottom-6 right-6 z-50 bg-[#25D366] p-3 rounded-full shadow-lg hover:scale-110 transition-transform">
        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984a9.964 9.964 0 001.333 4.993L2 22l5.233-1.237a9.921 9.921 0 004.779 1.237h.004c5.505 0 9.988-4.478 9.989-9.984 0-2.669-1.037-5.176-2.922-7.062A9.925 9.925 0 0012.012 2z"/></svg>
    </a>

    @stack('scripts')
</body>
</html>