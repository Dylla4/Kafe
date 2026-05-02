@extends('layouts.app')

@section('content')

{{-- SECTION: PROMO BANNER ALA SHOPEE --}}
<section class="bg-[#FDFBF7] py-6 border-b border-stone-200">
    <div class="max-w-[1100px] mx-auto px-4 md:px-10">
        
        {{-- Slider Container --}}
        <div id="shopeeSlider" class="flex overflow-x-auto snap-x snap-mandatory scrollbar-hide gap-6 pb-4 scroll-smooth">
            
            @php
                // Daftar aset sesuai data folder Anda
                $promos = [
                    'promo1.png', 'promo2.png', 'promo3.png', 'promo4.png'
                ];
            @endphp

            @foreach ($promos as $index => $promo)
            {{-- Slide Item: Lebar diatur agar hampir memenuhi layar namun menyisakan sedikit ruang di samping --}}
            <div class="flex-none w-full snap-center snap-always group">
                {{-- Rasio aspek disesuaikan menjadi 3:1 agar sangat memanjang seperti di gambar --}}
                <div class="relative overflow-hidden rounded-xl shadow-lg bg-white aspect-16/8">
                <img src="{{ asset('img/' . $promo) }}"
                    class="w-full h-full object-contain transition-transform duration-1000 group-hover:scale-105" 
                    alt="Promo">
                </div>
            </div>
            @endforeach

        </div>

        {{-- Indikator Titik (Dots) --}}
        <div id="sliderDots" class="flex justify-center items-center gap-2.5 mt-4">
            @foreach ($promos as $index => $promo)
                <div class="dot h-1.5 w-1.5 rounded-full bg-stone-300 transition-all duration-300"></div>
            @endforeach
        </div>
    </div>
</section>

<script>
    const slider = document.getElementById('shopeeSlider');
    const dots = document.querySelectorAll('.dot');
    
    function updateDots() {
        const scrollLeft = slider.scrollLeft;
        const items = slider.querySelectorAll('.flex-none');
        if (items.length === 0) return;
        
        const itemWidth = items[0].offsetWidth + 24; // 24 adalah gap-6
        const index = Math.round(scrollLeft / itemWidth);

        dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.add('bg-[#EE4D2D]', 'w-6');
                dot.classList.remove('bg-stone-300', 'w-1.5');
            } else {
                dot.classList.remove('bg-[#EE4D2D]', 'w-6');
                dot.classList.add('bg-stone-300', 'w-1.5');
            }
        });
    }

    let isUserInteracting = false;

    // Auto slide setiap 4 detik
    let autoSlide = setInterval(() => {
        if (isUserInteracting) return;

        const items = slider.querySelectorAll('.flex-none');
        if (items.length === 0) return;
        const itemWidth = items[0].offsetWidth + 24;
        
        if (Math.ceil(slider.scrollLeft + slider.offsetWidth) >= slider.scrollWidth - 10) {
            slider.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
            slider.scrollBy({ left: itemWidth, behavior: 'smooth' });
        }
    }, 4000);

    slider.addEventListener('touchstart', () => { isUserInteracting = true; }, {passive: true});
    slider.addEventListener('mousedown', () => { isUserInteracting = true; });
    slider.addEventListener('scroll', updateDots);
    
    updateDots();
</script>

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

{{-- SECTION 1: PROMOS --}}
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
            <div class="w-12 h-0.5 bg-[#A06040] mx-auto mt-6"></div>
        </div>

        {{-- Grid Container --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
            @php
                $promos = [
                    ['id' => 45, 'name' => 'Red Velvet Milkshake', 'discount' => '10%', 'img' => 'https://i.pinimg.com/1200x/5f/03/20/5f0320a4bcb98226d2bc0fccb4b0d511.jpg'],
                    ['id' => 46, 'name' => 'Hazelnut Bliss', 'discount' => '20%', 'img' => 'https://i.pinimg.com/736x/c6/23/04/c62304b2070821b7a8f445b405694977.jpg'],
                    ['id' => 47, 'name' => 'Pure Matcha', 'discount' => '12%', 'img' => 'https://i.pinimg.com/736x/3d/41/66/3d416603eef008ad247deb24b1044982.jpg'],
                    ['id' => 48, 'name' => 'Espresso Solo', 'discount' => '5%', 'img' => 'https://i.pinimg.com/1200x/a8/19/f8/a819f85ea056bf3dd5be18f48ca3e541.jpg'],
                    ['id' => 49, 'name' => 'Caramel Bliss', 'discount' => '10%', 'img' => 'https://i.pinimg.com/736x/0a/cd/df/0acddf8afff464f0f332271990539301.jpg'],
                    ['id' => 50, 'name' => 'Iced Americano', 'discount' => '30%', 'img' => 'https://i.pinimg.com/1200x/f0/45/63/f0456360847ccb1ff8bb1d72b7714c1a.jpg'],
                    ['id' => 51, 'name' => 'Mango Smoothie', 'discount' => '15%', 'img' => 'https://i.pinimg.com/1200x/b9/4e/ca/b94eca63094307959f0d8a67142598b0.jpg'],
                    ['id' => 52, 'name' => 'Midnight Mocha Brew', 'discount' => '25%', 'img' => 'https://i.pinimg.com/1200x/68/7f/26/687f26321d819b3226bc59da17d4eb08.jpg'],
                    ['id' => 53, 'name' => 'Mocha Magic', 'discount' => '10%', 'img' => 'https://i.pinimg.com/1200x/70/0f/11/700f116df1ff53ecc03ca6aa75404ee8.jpg'],
                    ['id' => 54, 'name' => 'Vanilla Velvet', 'discount' => '15%', 'img' => 'https://i.pinimg.com/1200x/32/58/39/32583955510da20a6abdb21eb9aa7e7d.jpg'],
                ];
            @endphp

            @foreach($promos as $promo)
            <div class="group relative bg-white border border-stone-100 shadow-sm hover:shadow-xl transition-all duration-500 rounded-xl overflow-hidden flex flex-col h-full">
                
                <div class="absolute top-3 left-3 z-20 bg-[#A06040] text-white px-2 py-1 font-bold text-[8px] rounded-md shadow-sm">
                    {{ $promo['discount'] }} OFF
                </div>

                <div class="aspect-square overflow-hidden">
                    <img src="{{ $promo['img'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $promo['name'] }}">
                </div>

                <div class="p-4 flex flex-col grow">
                    <h3 class="text-stone-800 font-bold uppercase tracking-wider text-[10px] mb-4 text-center line-clamp-1">
                        {{ $promo['name'] }}
                    </h3>
                    
                    <div class="mt-auto">
                        <form action="{{ route('cart.add', $promo['id']) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-[#2D2018] text-white py-2 rounded-xl font-bold hover:bg-[#C68B59] transition-colors uppercase text-[10px] tracking-widest">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- SECTION 2: HERO --}}
<section class="relative w-full overflow-hidden shadow-2xl bg-[#2D1B14] min-h-150 lg:min-h-187.5 flex items-center">
    
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1506372023823-741c83b836fe?q=80&w=2070" 
             class="w-full h-full object-cover grayscale-20]" alt="Biji Kopi Valeria">
        <div class="absolute inset-0 bg-linear-to-r from-[#2D1B14] via-[#2D1B14]/95 to-[#2D1B14]/40"></div>
    </div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-8 py-20 lg:px-16 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        
        <div class="flex flex-col items-start space-y-8">
            
            <div class="group cursor-default">
                <h2 class="flex flex-col">
                    <span class="text-white text-3xl lg:text-4xl font-serif font-black tracking-[0.25em] uppercase leading-none mb-1 transition-colors group-hover:text-[#A06040]">
                        Valeria
                    </span>
                    <div class="h-0.5] w-12 bg-[#A06040] my-1 transition-all duration-500 group-hover:w-full"></div>
                    <span class="text-[#A06040] text-[10px] tracking-[0.6em] font-light uppercase pl-1">
                        Coffee
                    </span>
                </h2>
            </div>

            <h1 class="text-white text-5xl md:text-6xl lg:text-8xl font-serif font-bold leading-none tracking-tight">
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
                
                <div class="relative w-72 h-72 md:w-100 md:h-100 lg:w-125 lg:h-125 rounded-full overflow-hidden border-16 border-white/5 shadow-2xl transition-transform duration-700 group-hover:scale-105">
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
                <div class="h-0.5 w-16 bg-[#A06040] mx-auto mt-6"></div>
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
                <div class="relative overflow-hidden aspect-16/10 mb-8 shadow-2xl shadow-stone-200">
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
                        Read Story <span class="h-px w-8 bg-[#3C2A21]"></span>
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