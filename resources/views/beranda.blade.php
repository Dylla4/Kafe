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

<section class="py-24 bg-[#FDFBF7]">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-black text-[#3C2A21] mb-16 uppercase tracking-widest">Kenapa Memilih Kami?</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-2xl transition duration-500 group border border-stone-100">
                <div class="w-16 h-16 bg-[#F5EBE0] rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-[#A06040] transition-colors duration-300">
                    <span class="text-3xl group-hover:scale-110 transition">🌱</span>
                </div>
                <h4 class="font-bold text-lg mb-3 text-[#3C2A21]">Biji Pilihan</h4>
                <p class="text-stone-500 text-sm leading-relaxed">Hanya menggunakan biji kopi arabika terbaik dari petani lokal.</p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-2xl transition duration-500 group border border-stone-100">
                <div class="w-16 h-16 bg-[#F5EBE0] rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-[#A06040] transition-colors duration-300">
                    <span class="text-3xl group-hover:scale-110 transition">🧑‍🍳</span>
                </div>
                <h4 class="font-bold text-lg mb-3 text-[#3C2A21]">Ahli Barista</h4>
                <p class="text-stone-500 text-sm leading-relaxed">Diseduh oleh tangan profesional untuk hasil konsisten.</p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-2xl transition duration-500 group border border-stone-100">
                <div class="w-16 h-16 bg-[#F5EBE0] rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-[#A06040] transition-colors duration-300">
                    <span class="text-3xl group-hover:scale-110 transition">🛒</span>
                </div>
                <h4 class="font-bold text-lg mb-3 text-[#3C2A21]">Pesan Mudah</h4>
                <p class="text-stone-500 text-sm leading-relaxed">Sistem keranjang yang cepat dan riwayat pesanan transparan.</p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-2xl transition duration-500 group border border-stone-100">
                <div class="w-16 h-16 bg-[#F5EBE0] rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-[#A06040] transition-colors duration-300">
                    <span class="text-3xl group-hover:scale-110 transition">✨</span>
                </div>
                <h4 class="font-bold text-lg mb-3 text-[#3C2A21]">Vibe Estetik</h4>
                <p class="text-stone-500 text-sm leading-relaxed">Tempat yang nyaman untuk nugas ataupun sekadar bersantai.</p>
            </div>
        </div>
    </div>
</section>

@endsection