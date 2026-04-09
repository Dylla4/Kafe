@extends('layouts.app')

@section('content')
<section class="relative h-[85vh] flex items-center overflow-hidden bg-[#1A120B]">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&q=80&w=2070" 
             class="w-full h-full object-cover opacity-50 scale-105 hover:scale-100 transition duration-[5s]" alt="Hero Coffee">
        <div class="absolute inset-0 bg-linear-to-r from-[#1A120B]/90 to-transparent"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10 w-full">
        <div class="max-w-2xl">
            <span class="text-[#A06040] font-bold uppercase tracking-[0.3em] text-xs mb-4 block animate-bounce">Premium Coffee Experience</span>
            <h1 class="text-5xl md:text-7xl font-extrabold text-[#FDFBF7] leading-tight mb-6">
                Cita Rasa Terbaik <br> di <span class="text-[#A06040]">Setiap Tegukan</span>
            </h1>
            <p class="text-stone-300 text-lg mb-10 leading-relaxed">
                Nikmati perpaduan biji kopi pilihan dengan teknik roasting sempurna untuk memulai hari Anda dengan penuh inspirasi.
            </p>
            <div class="flex gap-4">
                <a href="/menu" class="bg-[#A06040] text-white px-8 py-4 rounded-full font-bold hover:bg-[#3C2A21] transition-all duration-300 shadow-xl shadow-black/20">
                    Mulai Pesan
                </a>
                <a href="#tentang" class="border border-[#FDFBF7]/30 text-[#FDFBF7] px-8 py-4 rounded-full font-bold hover:bg-[#FDFBF7] hover:text-[#1A120B] transition-all">
                    Cerita Kami
                </a>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div class="max-w-xl">
                <span class="text-[#A06040] font-black uppercase tracking-[0.3em] text-xs mb-3 block">Rekomendasi Terbaik</span>
                <h2 class="text-4xl font-black text-[#3C2A21] leading-tight">Menu Favorit <br><span class="italic text-[#A06040]">Valeria Coffee</span></h2>
            </div>
            <a href="/menu" class="group flex items-center text-[#3C2A21] font-black uppercase tracking-widest text-sm hover:text-[#A06040] transition-colors">
                Lihat Semua Menu 
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach($featuredMenus as $menu)
            <div class="group relative bg-stone-50 rounded-[2.5rem] p-5 border border-stone-100 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <div class="aspect-square rounded-[2rem] overflow-hidden mb-8 shadow-inner relative">
                    @if($menu->foto)
                        <img src="{{ asset($menu->foto) }}" ... > 
                             alt="{{ $menu->nama_menu }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-stone-200 text-5xl font-bold">☕</div>
                    @endif
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-2xl shadow-sm">
                        <span class="text-[#A06040] font-black text-sm">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="px-2 pb-4">
                    <h3 class="text-xl font-black text-[#3C2A21] uppercase tracking-tight mb-2">{{ $menu->nama_menu }}</h3>
                    <p class="text-stone-400 text-sm line-clamp-2 mb-8 leading-relaxed">
                        {{ $menu->deskripsi ?? 'Nikmati sensasi rasa kopi autentik yang dibuat dengan sepenuh hati.' }}
                    </p>
                    
                    <a href="/menu" class="flex items-center justify-center w-full py-4 bg-[#3C2A21] text-white rounded-2xl font-black uppercase tracking-widest text-xs group-hover:bg-[#A06040] shadow-lg shadow-black/5 transition-all active:scale-95">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection