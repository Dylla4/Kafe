@extends('layouts.app')

@section('content')
<section class="relative min-h-screen flex items-center bg-[#1A120B] overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&q=80&w=2070" 
             class="w-full h-full object-cover opacity-30 scale-105" alt="Hero Coffee">
        <div class="absolute inset-0 bg-linear-to-b from-black/60 via-black/20 to-[#1A120B]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10 w-full pt-24 pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            
            <div class="lg:col-span-7 text-[#FDFBF7]">
                <span class="text-[#A06040] font-bold uppercase tracking-[0.4em] text-[10px] md:text-xs mb-6 block animate-pulse">
                    Premium Coffee Experience
                </span>
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-serif leading-[1.1] mb-8 tracking-tight">
                    Start your day <br> 
                    <span class="italic font-light text-stone-400">with a coffee</span>
                </h1>
                <p class="text-stone-300 text-base md:text-lg mb-12 max-w-md leading-relaxed opacity-90 font-light">
                    Nikmati perpaduan biji kopi pilihan dengan teknik roasting sempurna khas <span class="text-[#A06040] font-medium">Valeria Coffee</span>.
                </p>
                <div class="flex flex-wrap gap-6 items-center">
                    <a href="/menu" class="group relative overflow-hidden border border-[#FDFBF7] px-12 py-4 font-bold transition-all duration-500 hover:text-[#1A120B]">
                        <span class="relative z-10 uppercase tracking-[0.2em] text-xs">Order Now</span>
                        <div class="absolute inset-0 bg-[#FDFBF7] translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                    </a>
                    <div class="flex gap-4">
                        <span class="w-8 h-[1px] bg-[#A06040] self-center"></span>
                        <p class="text-[10px] uppercase tracking-widest text-stone-500">Since 2026</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 hidden lg:flex gap-4 items-center justify-end">
                @foreach($featuredMenus->take(2) as $menu)
                <div class="w-56 bg-white p-3 shadow-2xl transform transition-all duration-700 hover:-translate-y-6 {{ $loop->iteration % 2 == 0 ? 'mt-20' : '-mt-10' }}">
                    <div class="aspect-[4/5] overflow-hidden mb-5">
                        <img src="{{ $menu->foto ? asset($menu->foto) : 'https://images.unsplash.com/photo-1541167760496-162955ed8a9f?q=80&w=600' }}" 
                             class="w-full h-full object-cover grayscale-[0.2] hover:grayscale-0 transition-all duration-500" 
                             alt="{{ $menu->nama_menu }}">
                    </div>
                    <div class="px-2">
                        <h4 class="text-[#3C2A21] font-bold text-base mb-1 uppercase tracking-tighter">{{ $menu->nama_menu }}</h4>
                        <div class="flex justify-between items-center mt-4 pt-4 border-t border-stone-100">
                             <p class="text-[#A06040] text-[9px] font-black uppercase tracking-widest">Details</p>
                             <svg class="w-4 h-4 text-[#A06040]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="py-32 bg-[#FDFBF7]">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-20 gap-8">
            <div class="max-w-xl">
                <span class="text-[#A06040] font-bold uppercase tracking-[0.4em] text-[10px] mb-4 block">Recommended for you</span>
                <h2 class="text-4xl md:text-5xl font-black text-[#3C2A21] leading-none uppercase tracking-tighter">
                    Our <span class="italic font-serif font-light text-[#A06040] lowercase">best</span> Seller
                </h2>
            </div>
            <a href="/menu" class="group flex items-center text-[#3C2A21] font-bold uppercase tracking-widest text-[11px] border-b-2 border-[#3C2A21]/10 pb-2 hover:border-[#A06040] transition-all">
                Explore Full Menu 
                <svg class="h-4 w-4 ml-3 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-12">
    @foreach($featuredMenus as $menu)
    <div class="group relative transition-all duration-500 h-full flex flex-col">
        
        <div class="aspect-square overflow-hidden mb-8 relative shadow-2xl shadow-stone-200 flex-shrink-0">
            <img src="{{ $menu->foto ? asset($menu->foto) : 'https://via.placeholder.com/400x400?text=Coffee' }}" 
                 alt="{{ $menu->nama_menu }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-[1.5s]">
            
            <div class="absolute bottom-0 left-0 bg-[#FDFBF7] px-6 py-3">
                <span class="text-[#3C2A21] font-black text-sm tracking-tighter">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="text-center md:text-left flex flex-col flex-grow">
            <h3 class="text-xl font-bold text-[#3C2A21] uppercase tracking-tighter mb-3">
                {{ $menu->nama_menu }}
            </h3>
            
            <p class="text-stone-400 text-sm line-clamp-2 mb-8 leading-relaxed font-light flex-grow">
                {{ $menu->deskripsi ?? 'Eksplorasi cita rasa autentik dari pilihan menu terbaik kami, khusus untuk Anda.' }}
            </p>

            <div class="mt-auto">
                <a href="/menu" class="inline-block w-full text-center py-4 border border-[#3C2A21] text-[#3C2A21] font-bold uppercase tracking-[0.2em] text-[10px] hover:bg-[#3C2A21] hover:text-white transition-all">
                    Add to Cart
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
    </div>
</section>
@endsection