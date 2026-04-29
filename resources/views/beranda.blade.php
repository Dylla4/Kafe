@extends('layouts.app')

@section('content')

{{-- SECTION 1: PROMOS (HORIZONTAL SLIDER) --}}
<section class="bg-[#FDFBF7] pt-24 pb-24 border-b border-stone-100">
    <div class="max-w-7xl mx-auto px-6">
        
        {{-- Header Section --}}
        <div class="text-center mb-16">
            <span class="text-[#A06040] font-bold uppercase tracking-[0.4em] text-[10px] mb-3 block">
                Exclusive Deals
            </span>
            <h2 class="text-stone-900 text-5xl font-bold tracking-tighter">
                Valeria <span class="font-serif italic font-light text-[#A06040]">Promos</span>
            </h2>
            <div class="w-12 h-[2px] bg-[#A06040] mx-auto mt-6"></div>
        </div>

        {{-- Grid Container (Menyusun ke bawah, ukuran lebih kecil) --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
            @php
                $promos = [
                    ['name' => 'Morning Latte', 'discount' => '10%', 'img' => 'https://images.unsplash.com/photo-1509042239265-017696483182?q=80&w=400'],
                    ['name' => 'Midnight Brew', 'discount' => '25%', 'img' => 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?q=80&w=400'],
                    ['name' => 'Caramel Bliss', 'discount' => '10%', 'img' => 'https://images.unsplash.com/photo-1442512595331-e89e73853f31?q=80&w=400'],
                    ['name' => 'Vanilla Velvet', 'discount' => '15%', 'img' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=400'],
                    ['name' => 'Hazelnut Dream', 'discount' => '20%', 'img' => 'https://images.unsplash.com/photo-1541167760496-162955ed8a9f?q=80&w=400'],
                    ['name' => 'Mocha Magic', 'discount' => '10%', 'img' => 'https://images.unsplash.com/photo-1506619216599-9d16d0903dfd?q=80&w=400'],
                    ['name' => 'Iced Americano', 'discount' => '30%', 'img' => 'https://images.unsplash.com/photo-1517701550927-30cf4bb1dba5?q=80&w=400'],
                    ['name' => 'Espresso Solo', 'discount' => '5%', 'img' => 'https://images.unsplash.com/photo-1510707577719-af7c184a7b59?q=80&w=400'],
                    ['name' => 'Flat White', 'discount' => '12%', 'img' => 'https://images.unsplash.com/photo-1536816579748-4fcb3f49a7f4?q=80&w=400'],
                    ['name' => 'Cold Brew', 'discount' => '15%', 'img' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?q=80&w=400'],
                ];
            @endphp

            @foreach($promos as $promo)
            {{-- Card Kecil --}}
            <div class="group relative bg-white border border-stone-100 shadow-sm hover:shadow-xl transition-all duration-500 rounded-xl overflow-hidden flex flex-col h-full">
                
                {{-- Diskon Tag (Ukuran dikecilkan) --}}
                <div class="absolute top-3 left-3 z-20 bg-[#A06040] text-white px-2 py-1 font-bold text-[8px] rounded-md shadow-sm">
                    {{ $promo['discount'] }} OFF
                </div>

                {{-- Gambar (Rasio dikecilkan) --}}
                <div class="aspect-square overflow-hidden">
                    <img src="{{ $promo['img'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $promo['name'] }}">
                </div>

                {{-- Info Menu (Padding dikurangi agar ringkas) --}}
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="text-stone-800 font-bold uppercase tracking-wider text-[10px] mb-4 text-center line-clamp-1">
                        {{ $promo['name'] }}
                    </h3>
                    
                    <div class="mt-auto">
                        <button class="w-full bg-[#3C2A21] text-white py-2.5 text-[8px] font-bold uppercase tracking-widest hover:bg-[#A06040] transition-all rounded-lg active:scale-95">
                            Add
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- SECTION: BRAND VALUES --}}
<section class="py-12 bg-white px-6 -mt-10 relative z-30">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            
            <a href="#" class="group flex flex-col items-center p-5 bg-orange-50 rounded-[2rem] transition-all duration-300 hover:bg-orange-700 shadow-sm hover:-translate-y-1">
                <div class="w-12 h-12 bg-orange-700 text-white rounded-xl flex items-center justify-center mb-3 group-hover:bg-white group-hover:text-orange-700 transition-colors shadow-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                </div>
                <span class="text-[8px] uppercase tracking-widest font-bold text-orange-700 group-hover:text-orange-100 mb-0.5">Limited</span>
                <p class="text-stone-800 font-serif font-bold text-sm group-hover:text-white">Promosi</p>
            </a>

            <a href="#" class="group flex flex-col items-center p-5 bg-stone-50 rounded-[2rem] transition-all duration-300 hover:bg-stone-900 shadow-sm hover:-translate-y-1">
                <div class="w-12 h-12 bg-stone-200 text-stone-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-orange-700 group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                </div>
                <span class="text-[8px] uppercase tracking-widest font-bold text-stone-400 group-hover:text-orange-400 mb-0.5">Top Pick</span>
                <p class="text-stone-800 font-serif font-bold text-sm group-hover:text-white">Best Seller</p>
            </a>

            <a href="#" class="group flex flex-col items-center p-5 bg-stone-50 rounded-[2rem] transition-all duration-300 hover:bg-stone-900 shadow-sm hover:-translate-y-1">
                <div class="w-12 h-12 bg-stone-200 text-stone-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-orange-700 group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h.01M10 14h.01M10 10h.01M14 14h.01M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path></svg>
                </div>
                <span class="text-[8px] uppercase tracking-widest font-bold text-stone-400 group-hover:text-orange-400 mb-0.5">Specialty</span>
                <p class="text-stone-800 font-serif font-bold text-sm group-hover:text-white">All Coffee</p>
            </a>

            <a href="#" class="group flex flex-col items-center p-5 bg-stone-50 rounded-[2rem] transition-all duration-300 hover:bg-stone-900 shadow-sm hover:-translate-y-1">
                <div class="w-12 h-12 bg-stone-200 text-stone-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-orange-700 group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                </div>
                <span class="text-[8px] uppercase tracking-widest font-bold text-stone-400 group-hover:text-orange-400 mb-0.5">Non-Coffee</span>
                <p class="text-stone-800 font-serif font-bold text-sm group-hover:text-white">Minuman</p>
            </a>

            <a href="#" class="group flex flex-col items-center p-5 bg-stone-50 rounded-[2rem] transition-all duration-300 hover:bg-stone-900 shadow-sm hover:-translate-y-1">
                <div class="w-12 h-12 bg-stone-200 text-stone-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-orange-700 group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c0 2.121-1.414 3.964-3.5 4.454-1.127.265-2.285.4-3.5.4s-2.373-.135-3.5-.4c-2.086-.49-3.5-2.333-3.5-4.454V12h14v3.546z"></path></svg>
                </div>
                <span class="text-[8px] uppercase tracking-widest font-bold text-stone-400 group-hover:text-orange-400 mb-0.5">Snacks</span>
                <p class="text-stone-800 font-serif font-bold text-sm group-hover:text-white">Camilan</p>
            </a>

            <a href="#" class="group flex flex-col items-center p-5 bg-stone-50 rounded-[2rem] transition-all duration-300 hover:bg-stone-900 shadow-sm hover:-translate-y-1">
                <div class="w-12 h-12 bg-stone-200 text-stone-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-orange-700 group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                </div>
                <span class="text-[8px] uppercase tracking-widest font-bold text-stone-400 group-hover:text-orange-400 mb-0.5">Main Dish</span>
                <p class="text-stone-800 font-serif font-bold text-sm group-hover:text-white">Makanan</p>
            </a>

        </div>
    </div>
</section>

{{-- SECTION 2: HERO --}}
<section class="relative w-full overflow-hidden shadow-2xl bg-[#2D1B14] min-h-[600px] lg:min-h-[750px] flex items-center">
    
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1506372023823-741c83b836fe?q=80&w=2070" 
             class="w-full h-full object-cover grayscale-[20%]" alt="Biji Kopi Valeria">
        <div class="absolute inset-0 bg-gradient-to-r from-[#2D1B14] via-[#2D1B14]/95 to-[#2D1B14]/40"></div>
    </div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-8 py-20 lg:px-16 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        
        <div class="flex flex-col items-start space-y-8">
            
            <div class="group cursor-default">
                <h2 class="flex flex-col">
                    <span class="text-white text-3xl lg:text-4xl font-serif font-black tracking-[0.25em] uppercase leading-none mb-1 transition-colors group-hover:text-[#A06040]">
                        Valeria
                    </span>
                    <div class="h-[2px] w-12 bg-[#A06040] my-1 transition-all duration-500 group-hover:w-full"></div>
                    <span class="text-[#A06040] text-[10px] tracking-[0.6em] font-light uppercase pl-1">
                        Coffee
                    </span>
                </h2>
            </div>

            <h1 class="text-white text-5xl md:text-6xl lg:text-8xl font-serif font-bold leading-[1] tracking-tight">
                Kopi begitu <br>
                <span class="text-stone-100">nikmat,</span> <br>
                <span class="italic font-light text-[#A06040]">manjakan lidah.</span>
            </h1>

            <p class="text-stone-400 text-lg md:text-xl font-light max-w-md leading-relaxed border-l-2 border-[#A06040] pl-6">
                Biji kopi pilihan, pemanggangan sempurna, cita rasa mendalam di setiap sesapan.
            </p>

            <div class="flex flex-wrap gap-5 pt-4">
                <a href="#" class="bg-[#8B573C] hover:bg-[#A06040] text-white px-12 py-5 rounded-md font-bold text-xs uppercase tracking-widest transition-all duration-300 shadow-2xl hover:-translate-y-1">
                    Pesan Sekarang
                </a>
                <a href="#" class="border border-white/30 hover:border-white hover:bg-white/5 text-white px-10 py-5 rounded-md font-bold text-xs uppercase tracking-widest transition-all duration-300">
                    Tentang Kami
                </a>
            </div>
        </div>

        <div class="flex justify-center items-center lg:justify-end">
            <div class="relative group">
                <div class="absolute inset-0 bg-[#A06040]/30 blur-[120px] rounded-full group-hover:bg-[#A06040]/40 transition-all duration-1000"></div>
                
                <div class="relative w-72 h-72 md:w-[400px] md:h-[400px] lg:w-[500px] lg:h-[500px] rounded-full overflow-hidden border-[16px] border-white/5 shadow-2xl transition-transform duration-700 group-hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1541167760496-1628856ab772?q=80&w=1000" 
                         class="w-full h-full object-cover scale-110" 
                         alt="Kopi Spesial Valeria">
                </div>

                <div class="absolute bottom-6 -left-6 bg-[#A06040] text-white px-8 py-3 rounded-lg shadow-2xl text-xs font-black uppercase tracking-widest">
                    Premium Quality
                </div>
            </div>
        </div>
    </div>
</section>


{{-- SECTION 3: OUR PROFESSIONAL BARISTAS --}}
<section class="py-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        
        {{-- Header Section dengan Navigasi --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div class="text-center md:text-left">
                <span class="text-[#A06040] font-bold uppercase tracking-[0.4em] text-[10px] mb-3 block">
                    The Experts Behind the Cup
                </span>
                <h2 class="text-stone-900 text-5xl font-bold tracking-tighter">
                    Meet Our <span class="font-serif italic font-light text-[#A06040]">Baristas</span>
                </h2>
            </div>

            {{-- Tombol Navigasi --}}
            <div class="hidden md:flex gap-2">
                <button onclick="document.getElementById('staff-container').scrollBy({left: -350, behavior: 'smooth'})" 
                        class="p-4 border border-stone-200 text-stone-400 hover:border-[#A06040] hover:text-[#A06040] rounded-full transition-all bg-white shadow-sm active:scale-90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <button onclick="document.getElementById('staff-container').scrollBy({left: 350, behavior: 'smooth'})" 
                        class="p-4 border border-stone-200 text-stone-400 hover:border-[#A06040] hover:text-[#A06040] rounded-full transition-all bg-white shadow-sm active:scale-90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>
        </div>

        {{-- Container Bergeser (Horizontal Scroll) --}}
        <div id="staff-container" class="flex overflow-x-auto gap-10 pb-12 snap-x snap-mandatory scrollbar-hide" style="scroll-behavior: smooth;">
            @php
                $staffs = [
                    ['name' => 'Alex Rivera', 'role' => 'Head Roaster', 'img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=400'],
                    ['name' => 'Sarah Jenkins', 'role' => 'Senior Barista', 'img' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=400'],
                    ['name' => 'Michael Chen', 'role' => 'Latte Art Specialist', 'img' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=400'],
                    ['name' => 'Emma Watson', 'role' => 'Coffee Sommelier', 'img' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=400'],
                    ['name' => 'David Miller', 'role' => 'Brew Master', 'img' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=400'],
                ];
            @endphp

            @foreach($staffs as $staff)
            <div class="min-w-[280px] md:min-w-[320px] snap-start group">
                {{-- Foto Staf --}}
                <div class="relative overflow-hidden aspect-[3/4] mb-6 rounded-2xl shadow-sm group-hover:shadow-xl transition-all duration-500">
                    <img src="{{ $staff['img'] }}" 
                         class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700" 
                         alt="{{ $staff['name'] }}">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-[#3C2A21]/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-8">
                        <div class="flex gap-4">
                            <span class="text-white text-[10px] uppercase tracking-widest font-bold">View Profile</span>
                        </div>
                    </div>
                </div>

                {{-- Info Staf --}}
                <div class="text-center">
                    <h3 class="text-stone-800 font-bold uppercase tracking-widest text-sm mb-1 group-hover:text-[#A06040] transition-colors">
                        {{ $staff['name'] }}
                    </h3>
                    <p class="text-stone-400 font-serif italic text-xs">
                        {{ $staff['role'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- SECTION 4: VALERIA NEWS & JOURNAL --}}
<section class="py-32 bg-[#FDFBF7] border-t border-stone-100">
    <div class="max-w-7xl mx-auto px-6">
        
        {{-- Header Section --}}
        <div class="flex flex-col items-center justify-center mb-20 gap-8 text-center">
            <div class="max-w-xl mx-auto">
                <span class="text-[#A06040] font-bold uppercase tracking-[0.4em] text-[10px] mb-4 block">
                    Inside Our Roastery
                </span>
                <h2 class="text-5xl md:text-6xl font-black text-[#3C2A21] leading-[0.9] uppercase tracking-tighter">
                    Valeria <span class="italic font-serif font-light text-[#A06040] lowercase">Journal</span>
                </h2>
                <div class="h-[2px] w-16 bg-[#A06040] mx-auto mt-6"></div>
            </div>
        </div>

        {{-- Grid Berita --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            @php
                $news = [
                    [
                        'date' => '24 April 2026',
                        'title' => 'Seni Roasting: Rahasia di Balik Aroma Kopi Valeria',
                        'category' => 'Craftmanship',
                        'img' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=600'
                    ],
                    [
                        'date' => '18 April 2026',
                        'title' => 'Mengenal Biji Kopi Single Origin dari Dataran Tinggi Gayo',
                        'category' => 'Education',
                        'img' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?q=80&w=600'
                    ],
                    [
                        'date' => '10 April 2026',
                        'title' => 'Valeria Coffee Kini Hadir dengan Konsep Open Bar Terbaru',
                        'category' => 'Update',
                        'img' => 'https://images.unsplash.com/photo-1442512595331-e89e73853f31?q=80&w=600'
                    ],
                ];
            @endphp

            @foreach($news as $item)
            <div class="group cursor-pointer">
                {{-- Gambar Berita --}}
                <div class="relative overflow-hidden aspect-[16/10] mb-8 shadow-2xl shadow-stone-200">
                    <img src="{{ $item['img'] }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[1.5s]" 
                         alt="{{ $item['title'] }}">
                    
                    {{-- Label Kategori --}}
                    <div class="absolute top-4 left-4 bg-white px-3 py-1 text-[9px] font-black uppercase tracking-widest text-[#3C2A21]">
                        {{ $item['category'] }}
                    </div>
                </div>

                {{-- Konten Berita --}}
                <div class="flex flex-col">
                    <span class="text-[#A06040] font-bold text-[10px] uppercase tracking-widest mb-3">
                        {{ $item['date'] }}
                    </span>
                    <h3 class="text-xl font-bold text-[#3C2A21] leading-snug mb-4 group-hover:text-[#A06040] transition-colors line-clamp-2">
                        {{ $item['title'] }}
                    </h3>
                    <p class="text-stone-400 text-xs font-light leading-relaxed mb-6">
                        Temukan kisah mendalam dan informasi terbaru seputar dunia kopi langsung dari para ahli kami...
                    </p>
                    <div class="flex items-center gap-2 text-[#3C2A21] font-bold text-[10px] uppercase tracking-tighter group-hover:gap-4 transition-all">
                        Read Story <span class="h-[1px] w-8 bg-[#3C2A21]"></span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
<style>
    @keyframes slow-zoom { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }
    .animate-slow-zoom { animation: slow-zoom 20s ease-in-out infinite alternate; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .animate-fade-in { animation: fadeIn 1.5s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in-up { animation: fadeInUp 1s ease-out both; }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in-down { animation: fadeInDown 1s ease-out both; }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
</style>