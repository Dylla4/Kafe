@extends('layouts.app')

@section('content')

<section class="relative bg-white overflow-hidden group">
    {{-- Tombol Navigasi Kiri --}}
    <button onclick="prevSlide()" class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-30 bg-white/80 hover:bg-[#004d31] hover:text-white text-[#004d31] p-3 rounded-full shadow-md transition-all opacity-0 group-hover:opacity-100 hidden md:flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    {{-- Tombol Navigasi Kanan --}}
    <button onclick="nextSlide()" class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-30 bg-white/80 hover:bg-[#004d31] hover:text-white text-[#004d31] p-3 rounded-full shadow-md transition-all opacity-0 group-hover:opacity-100 hidden md:flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    {{-- Container Slider --}}
    <div id="foreSlider" class="flex overflow-x-auto snap-x snap-mandatory scrollbar-hide scroll-smooth">
        @php
            $slides = [
                ['title' => 'Promo', 'sub' => 'BUY 1 GET 1', 'desc' => 'Nikmati kesegaran kopi favoritmu lebih hemat. Beli satu varian caramel, dapatkan satu lagi gratis!.', 'img' => '10.png'],
                ['title' => 'Promo', 'sub' => 'Menu Baru', 'desc' => 'Nikmati kelezatan tradisional dengan sentuhan modern. Lumpiah goreng renyah yang siap menemani Harimuuu.', 'img' => '4.png'],
                ['title' => 'Promo', 'sub' => 'Asian Fusion', 'desc' => 'Nikmati harmoni rasa autentik Asia. Onigiri yang lembut dan Gimbap yang kaya rasa, kini hadir menemani waktu kopi Anda.', 'img' => '1.png'],
                ['title' => 'Promo', 'sub' => 'Weekend', 'desc' => 'Rasakan kesegaran nyata dari perpaduan teh pilihan dan irisan lemon segar.', 'img' => '2.png'],
            ];
        @endphp

        @foreach ($slides as $slide)
        <div class="flex-none w-full snap-center bg-[#F9F9F9] min-h-[500px] md:min-h-[600px] flex items-center">
            <div class="max-w-7xl mx-auto px-8 md:px-16 w-full grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                {{-- Text Area --}}
                <div class="order-2 md:order-1 space-y-6">
                    <h1 class="text-[#004d31] text-6xl md:text-8xl font-bold leading-[0.8] tracking-tighter">
                        {{ $slide['title'] }} <br>
                        <span class="font-serif italic font-light text-[#A06040]">{{ $slide['sub'] }}</span>
                    </h1>
                    <p class="text-stone-500 text-lg max-w-sm font-light leading-relaxed">
                        {{ $slide['desc'] }}
                    </p>
                </div>
                {{-- Image Area --}}
                <div class="order-1 md:order-2 flex justify-center">
                    <img src="{{ asset('img/' . $slide['img']) }}" class="w-full max-w-md object-contain drop-shadow-2xl" alt="Product">
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Indikator Dots --}}
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex gap-3 z-20">
        @foreach ($slides as $index => $s)
    <button data-index="{{ $index }}" 
            class="dot-navigation h-1.5 w-8 bg-stone-300 rounded-full transition-all duration-500">
    </button>
@endforeach
    </div>
</section>

<script>
    const slider = document.getElementById('foreSlider');
    const dots = document.querySelectorAll('.fore-dot');

    function updateDots() {
        const index = Math.round(slider.scrollLeft / slider.offsetWidth);
        dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.add('bg-[#004d31]', 'w-12');
                dot.classList.remove('bg-stone-300', 'w-8');
            } else {
                dot.classList.remove('bg-[#004d31]', 'w-12');
                dot.classList.add('bg-stone-300', 'w-8');
            }
        });
    }

    function nextSlide() {
        if (slider.scrollLeft + slider.offsetWidth >= slider.scrollWidth - 1) {
            slider.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
            slider.scrollBy({ left: slider.offsetWidth, behavior: 'smooth' });
        }
    }

    function prevSlide() {
        if (slider.scrollLeft <= 0) {
            slider.scrollTo({ left: slider.scrollWidth, behavior: 'smooth' });
        } else {
            slider.scrollBy({ left: -slider.offsetWidth, behavior: 'smooth' });
        }
    }

    function goToSlide(index) {
        slider.scrollTo({ left: slider.offsetWidth * index, behavior: 'smooth' });
    }

    slider.addEventListener('scroll', updateDots);
    window.addEventListener('load', updateDots);
</script>

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

{{-- SECTION: OUR STORY --}}
<section class="relative py-24 bg-white overflow-hidden">
    {{-- Teks Latar Belakang (Watermark) --}}
    <div class="absolute top-10 left-0 w-full overflow-hidden whitespace-nowrap pointer-events-none select-none opacity-[0.03] z-0">
        <span class="text-[180px] font-bold text-stone-900 leading-none">
            our story our story our story our story our story
        </span>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            
            {{-- Bagian Kiri: Judul dan Gambar --}}
            <div class="space-y-8">
                <h2 class="text-[#004d31] text-7xl md:text-8xl font-bold tracking-tighter animate-fade-in-up">
                    Our Story
                </h2>
                
                <div class="relative rounded-[60px] overflow-hidden shadow-2xl shadow-stone-200 aspect-[4/5] md:aspect-square lg:aspect-[4/5]">
                    <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=1000" 
                         class="w-full h-full object-cover" 
                         alt="Our Store Interior">
                </div>
            </div>

            {{-- Bagian Kanan: Teks Deskripsi --}}
            <div class="pt-0 lg:pt-32 space-y-8">
                <div class="prose prose-stone">
                    <p class="text-stone-600 text-lg leading-relaxed font-light">
                        Didirikan pada tahun 2018, <strong class="text-[#004d31] font-bold">Valeria Coffee</strong> adalah startup kopi yang bercita-cita membuat kopi spesial terbaik untuk pelanggan. Seperti nama kami yang diambil dari kata "Valiant" yang berarti keberanian, kami ingin tumbuh kuat, konsisten, dan menciptakan kehidupan yang bermakna di sekitar. Kami ingin kehadiran kami bisa meningkatkan kualitas kopi dalam komunitas kita.
                    </p>
                    
                    <p class="text-stone-600 text-lg leading-relaxed font-light">
                        Dengan jaringan dan pengalaman, kami menggunakan teknologi terkini untuk alat dan biji kopi kami. Diambil langsung dari petani pilihan, biji kopi berkualitas tinggi diproses dan dipanggang sempurna oleh kami, dan diajarkan kepada barista kompeten dengan semangat yang tulus.
                    </p>
                </div>

                {{-- Tombol Selengkapnya (Opsional) --}}
                    <div class="pt-4">
                        <a href="{{ route('tentang') }}" class="inline-block border-2 border-[#004d31] text-[#004d31] px-10 py-3 rounded-full font-bold hover:bg-[#004d31] hover:text-white transition-all duration-300">
                            Selengkapnya
                        </a>
                    </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Tambahkan jika belum ada di file utama */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&display=swap');
    
    section {
        font-family: 'Inter', sans-serif;
    }

    h2 {
        letter-spacing: -0.05em;
    }
</style>

{{-- SECTION: VALERIA NEWS --}}
<section class="py-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        
        {{-- Header News --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-6 relative">
             {{-- Watermark Text --}}
             <div class="absolute -top-12 left-0 pointer-events-none select-none opacity-[0.03] z-0">
                <span class="text-[120px] font-bold text-stone-900 leading-none">
                    VALERIANEWS
                </span>
            </div>

            <div class="relative z-10">
                <h2 class="text-[#004d31] text-6xl md:text-7xl font-bold tracking-tighter">
                    ValeriaNews
                </h2>
            </div>
            
            <p class="text-stone-400 text-lg md:max-w-xs leading-tight relative z-10">
                Dapatkan berita terbaru dan informasi menarik dari kami!
            </p>
        </div>

        {{-- News Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $newsList = [
                    [
                        'title' => '[Press Release] VALERIA Records 60.5% YoY Net...',
                        'location' => 'Jakarta, April 20, 2026 – PT Valeria Kopi Indonesia Tbk',
                        'date' => 'April 20, 2026',
                        'img' => 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=500'
                    ],
                    [
                        'title' => "[Press Release] VALERIA's Net Profit Surged 55%...",
                        'location' => 'Jakarta, March 31, 2026 – PT Valeria Kopi Indonesia Tbk',
                        'date' => 'April 1, 2026',
                        'img' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=500'
                    ],
                    [
                        'title' => 'Growing with the Community, VALERIA...',
                        'location' => 'TANGERANG, March 25, 2026 – PT Valeria Kopi Indonesia Tbk',
                        'date' => 'March 25, 2026',
                        'img' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?q=80&w=500'
                    ],
                    [
                        'title' => 'Frequently Asked Questions (FAQ) – Valeria...',
                        'location' => 'Does Valeria Coffee offer a franchise scheme? Valeria Coffee prioritizes...',
                        'date' => 'March 9, 2026',
                        'img' => 'https://images.unsplash.com/photo-1442512595331-e89e73853f31?q=80&w=500'
                    ],
                ];
            @endphp

            @foreach($newsList as $news)
            <div class="group cursor-pointer flex flex-col bg-white border border-stone-100 rounded-[32px] overflow-hidden hover:shadow-2xl hover:shadow-stone-200 transition-all duration-500">
                {{-- News Image --}}
                <div class="aspect-[4/3] overflow-hidden">
                    <img src="{{ $news['img'] }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" 
                         alt="News Image">
                </div>

                {{-- News Content --}}
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-stone-800 font-bold text-lg leading-snug mb-4 line-clamp-2 group-hover:text-[#004d31] transition-colors">
                        {{ $news['title'] }}
                    </h3>
                    
                    <p class="text-stone-400 text-xs leading-relaxed mb-8 line-clamp-3">
                        {{ $news['location'] }}
                    </p>

                    <div class="mt-auto pt-4 border-t border-stone-50">
                        <span class="text-stone-300 text-[10px] font-medium italic">
                            {{ $news['date'] }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- SECTION: PROMO --}}
<section class="py-24 bg-white overflow-hidden">
    {{-- Container Utama dengan Background Cream & Sudut Membulat Besar --}}
    <div class="max-w-7xl mx-auto bg-[#F9F8F3] rounded-[60px] pt-20 pb-24 px-6 md:px-12 relative overflow-hidden">
        
        {{-- Efek Sunburst (Garis Cahaya Melingkar) --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[120%] h-[600px] pointer-events-none opacity-40 z-0">
            <div class="w-full h-full" style="background: repeating-conic-gradient(from 0deg, #E8E5D8 0deg 10deg, transparent 10deg 20deg);"></div>
            {{-- Overlay Gradasi agar memudar ke bawah --}}
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#F9F8F3]/50 to-[#F9F8F3]"></div>
        </div>

        {{-- Header Promo --}}
        <div class="text-center mb-20 relative z-10">
            {{-- Watermark Text Outlined (Mirip Foto) --}}
            <div class="absolute -top-16 left-1/2 -translate-x-1/2 w-full pointer-events-none select-none opacity-10">
                <span class="text-[60px] md:text-[110px] font-bold leading-none block uppercase whitespace-nowrap tracking-widest text-transparent" style="-webkit-text-stroke: 2px #004d31;">
                    MORE BENEFITS & PROMO
                </span>
            </div>
            
            <div class="relative">
                <h2 class="text-[#004d31] text-5xl md:text-7xl font-bold tracking-tighter mb-4">
                    Promo di Valeria Coffee
                </h2>
                <p class="text-stone-500 text-xl font-light">
                    Temukan berbagai promo menarik di sini!
                </p>
            </div>
        </div>

        {{-- Promo Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $promos = [
                    [
                        'badge' => 'Promo Couple',
                        'sub' => 'Dua varian burger premium dengan daging juicy untuk dinikmati bersama pasangan',
                        'img' => asset('img/3.png'), 
                        'bgColor' => 'bg-[#F2F2F2]'
                    ],
                    [
                        'badge' => 'Promo Merdeka',
                        'sub' => 'Nikmati perpaduan gurihnya Dimsum Mentai dan segarnya Peach Tea dalam satu paket hemat',
                        'img' => asset('img/6.png'), 
                        'bgColor' => 'bg-[#FFF8E7]'
                    ],
                    [
                        'badge' => 'Promo Valentine',
                        'sub' => 'Rayakan momen manis dengan kelembutan Red Velvet Cake spesial untuk orang tersayang',
                        'img' => asset('img/7.png'), 
                        'bgColor' => 'bg-[#FFF8E7]'
                    ],
                ];
            @endphp

            @foreach($promos as $promo)
            <div class="{{ $promo['bgColor'] }} rounded-[60px] p-12 flex flex-col min-h-[450px] group hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 relative overflow-hidden">
                
                {{-- Text Content --}}
                <div class="relative z-10 w-full mb-6">
                    <h3 class="text-[#004d31] text-5xl font-bold leading-tight tracking-tighter">
                        {{ $promo['badge'] }}
                    </h3>
                    <p class="text-[#004d31]/70 font-medium italic text-base mt-1">
                        {{ $promo['sub'] }}
                    </p>
                </div>

                {{-- Image Area --}}
                <div class="relative z-10 w-full mt-auto flex justify-center items-center h-64 transform group-hover:scale-110 transition-transform duration-700">
                    <img src="{{ $promo['img'] }}" 
                         class="max-w-full max-h-full object-contain drop-shadow-[0_20px_20px_rgba(0,0,0,0.15)]" 
                         alt="{{ $promo['badge'] }}">
                </div>

                {{-- Decorative Background Text --}}
                <div class="absolute -right-4 top-1/2 -translate-y-1/2 opacity-[0.04] pointer-events-none select-none">
                    <span class="text-8xl font-black text-[#004d31] rotate-90 block tracking-widest">
                        PROMO
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    /* Tambahkan transisi halus untuk hover */
    .hover\:-translate-y-2:hover {
        transform: translateY(-0.5rem);
    }
</style>

{{-- SECTION: TESTIMONI --}}
<section class="py-24 bg-white overflow-hidden relative">

{{-- Ubah left-10 menjadi left-40 atau left-60 agar lebih dekat ke teks --}}
<img src="{{ asset('img/download1.png') }}" 
    class="absolute left-60 top-20 w-48 h-48 object-contain opacity-80 hidden lg:block rotate-[-15deg] z-0" 
    alt="Decor 1">

{{-- Ubah right-10 menjadi right-40 atau right-60 agar lebih dekat ke teks --}}
<img src="{{ asset('img/download2.png') }}" 
    class="absolute right-60 top-10 w-56 h-56 object-contain opacity-80 hidden lg:block rotate-[15deg] z-0" 
    alt="Decor 2">

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        
        {{-- Header Testimoni --}}
        <div class="text-center mb-20">
            <h2 class="text-[#004d31] text-6xl font-bold tracking-tighter mb-4">Testimoni</h2>
            <div class="inline-block border border-dashed border-[#004d31] px-6 py-2 rounded-full">
                <span class="text-[#004d31] font-medium italic">Kolaborasi Sukses Kami</span>
            </div>
        </div>

        {{-- Testimonial Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            @php
                $testimonials = [
                    [
                        'text' => 'Kami sangat mengapresiasi inisiatif dari Valeria Coffee untuk berkolaborasi bersama dalam kampanye ini. Semoga kolaborasi kami bisa menginspirasi banyak pihak.',
                        'author' => 'Sumanda Tondang',
                        'role' => 'Director of Fund Development at SOS Children\'s Villages',
                        'logo' => 'https://upload.wikimedia.org/wikipedia/commons/d/d1/SOS_Children%27s_Villages_logo.svg'
                    ],
                    [
                        'text' => 'Valeria Coffee is one of the best merchants that I ever handled. They had a great journey to create some collaborations such as Exclusive Seasonal Menu, Percaya Projex, etc.',
                        'author' => 'Devi Alfilovita',
                        'role' => 'Key Account Manager at GrabFood',
                        'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/a9/Grab_logo.svg'
                    ],
                    [
                        'text' => 'Valeria is a very collaborative merchant because, during the pandemic, we were able to collaborate to rebuild from scratch in order to achieve tremendous growth.',
                        'author' => 'Nina Sudianto',
                        'role' => 'Enterprise Merchant Partnerships at GoFood',
                        'logo' => 'https://upload.wikimedia.org/wikipedia/commons/9/9e/Gojek_logo_2019.svg'
                    ],
                ];
            @endphp

            @foreach($testimonials as $item)
            <div class="flex flex-col items-center">
                {{-- Bubble Chat --}}
                <div class="bg-white border border-stone-100 p-8 rounded-[30px] shadow-sm relative mb-10 text-center italic text-stone-500 text-sm leading-relaxed">
                    "{{ $item['text'] }}"
                    {{-- Tail of the bubble --}}
                    <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-6 h-6 bg-white border-b border-r border-stone-100 rotate-45"></div>
                </div>

                {{-- Partner Logo --}}
                <div class="h-12 mb-4 flex items-center justify-center">
                    <img src="{{ $item['logo'] }}" class="h-full object-contain grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all" alt="Partner Logo">
                </div>

                {{-- Author Info --}}
                <div class="text-center">
                    <h4 class="text-stone-800 font-bold text-lg">{{ $item['author'] }}</h4>
                    <p class="text-stone-400 text-[11px] leading-tight max-w-[200px] mx-auto uppercase tracking-wider">
                        {{ $item['role'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination Dots --}}
        <div class="flex justify-center gap-2 mt-16">
            <div class="w-2 h-2 rounded-full bg-[#004d31]"></div>
            @for($i=0; $i<4; $i++)
                <div class="w-2 h-2 rounded-full bg-stone-200"></div>
            @endfor
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