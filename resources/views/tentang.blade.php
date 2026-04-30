@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<section class="py-24 bg-[#FCF9F6] px-6 overflow-hidden">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-16 items-center">
        <div class="relative flex justify-center lg:justify-start">
            <div class="absolute -top-10 -left-10 w-64 h-64 bg-orange-100/40 rounded-full blur-3xl opacity-60"></div>
            <div class="relative group">
                <div class="relative z-10 w-full max-w-md aspect-[4/5] rounded-[2rem] overflow-hidden shadow-[0_30px_60px_-15px_rgba(0,0,0,0.2)] border-8 border-white">
                    <img src="{{ asset('img/poto.jpg') }}" alt="Filosofi Valeria Coffee"
                         class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                </div>
                <div class="absolute -bottom-6 -right-6 bg-[#A06040] text-white p-6 rounded-2xl shadow-xl z-20 hidden lg:block animate-bounce-slow">
                    <p class="text-[10px] uppercase tracking-[0.3em] font-bold opacity-80 mb-1">CITRA RASA</p>
                    <p class="text-xl font-serif font-bold italic">Autentik</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col space-y-8 lg:pr-10">
            <div class="flex items-center gap-3">
                <div class="h-[1px] w-12 bg-orange-700/40"></div>
                <span class="text-orange-700 text-xs font-bold uppercase tracking-[0.4em]">Our Journey</span>
            </div>
            <h2 class="text-5xl md:text-6xl font-serif font-bold text-stone-800 leading-[1.1] tracking-tight">
                Cerita Dibalik <br>
                <span class="text-orange-700 italic font-light">Valeria Coffee</span>
            </h2>
            <div class="space-y-6">
                <p class="text-xl text-stone-600 font-light leading-relaxed">
                    Valeria Coffee lahir dari sebuah mimpi sederhana: menjadikan kopi sebagai jembatan yang menghubungkan <span class="font-semibold text-stone-800 underline decoration-orange-200 underline-offset-4">kehangatan manusia dengan kekayaan alam</span>. 
                </p>
                <p class="text-lg text-stone-500 font-light leading-relaxed">
                    Kami percaya bahwa kopi terbaik tidak hanya datang dari mesin yang canggih, melainkan dari ketelitian tangan-tangan yang mencintai prosesnya. Bermula dari eksplorasi biji kopi lokal unggulan, kami mengkurasi setiap ceri kopi untuk memastikan karakter unik tanah nusantara tersampaikan dengan sempurna ke cangkir Anda.
                </p>
            </div>
            <div class="relative pt-6">
                <div class="absolute top-0 left-0 w-12 h-[2px] bg-orange-700/20"></div>
                <p class="italic text-stone-700 text-lg leading-relaxed pl-6 border-l-4 border-orange-700/20">
                    "Bagi kami, setiap tetes seduhan adalah bentuk penghormatan terhadap kerja keras petani dan ketulusan barista."
                </p>
            </div>
            <div class="flex gap-12 pt-6 border-t border-stone-100">
                <div class="group cursor-default">
                    <p class="text-3xl font-serif font-bold text-stone-800 group-hover:text-orange-700 transition-colors">100%</p>
                    <p class="text-[10px] uppercase tracking-widest text-stone-400 font-bold mt-1">Eksplorasi Lokal</p>
                </div>
                <div class="group cursor-default">
                    <p class="text-3xl font-serif font-bold text-stone-800 group-hover:text-orange-700 transition-colors">Infinite</p>
                    <p class="text-[10px] uppercase tracking-widest text-stone-400 font-bold mt-1">Dedikasi Rasa</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-white px-6">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row-reverse items-center gap-20">
        
    <div class="w-full md:w-1/2 flex justify-center lg:justify-end">
        <div class="relative group">
            <div class="absolute inset-0 bg-[#A06040]/5 rounded-full blur-3xl transform group-hover:scale-125 transition-transform duration-1000"></div>
            
            <div class="relative z-10 w-full max-w-[400px] aspect-square rounded-2xl overflow-hidden shadow-2xl border-4 border-stone-50">
                <img src="{{ asset('staff/Owner.jpeg') }}" alt="Valeria S. Adeline - Founder"
                    class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
            </div>
            
            <div class="absolute -bottom-8 -left-10 bg-[#1C1C1C] text-white p-8 rounded-2xl shadow-2xl z-20 transition-all duration-500 group-hover:-translate-y-3">
                <p class="text-[10px] uppercase tracking-[0.5em] font-bold text-orange-400 mb-2">Founder & Brand Director</p>
                <p class="font-serif text-3xl text-white opacity-90 tracking-tighter">Alexander Valerie</p>
            </div>
        </div>
    </div>

        <div class="w-full md:w-1/2 space-y-8">
            <div class="flex items-center gap-3">
                <span class="text-orange-700 text-[10px] font-bold uppercase tracking-[0.4em]">The Artisan</span>
                <div class="h-[1px] w-12 bg-orange-700/30"></div>
            </div>

            <h2 class="text-4xl md:text-5xl font-serif font-bold text-stone-800 leading-[1.2]">
                Menghidupkan Jiwa <br>
                <span class="text-orange-700 italic font-light text-3xl md:text-4xl">dalam Setiap Ruang & Waktu</span>
            </h2>

            <div class="space-y-6">
                <p class="text-xl text-stone-600 font-light leading-relaxed italic pl-6 border-l-4 border-orange-700/10">
                    "Kopi adalah bahasa sunyi yang mampu mencairkan suasana. Melalui Valeria, saya ingin merajut ruang di mana ide-ide besar lahir dari diskusi kecil di meja kafe."
                </p>
                <p class="text-lg text-stone-500 font-light leading-relaxed">
                    Perjalanan ini bermula dari kekaguman saya pada filosofi kopi—pahit yang menguatkan dan aroma yang menenangkan. Sebagai kurator di balik Valeria Coffee, saya berkomitmen untuk menjaga integritas rasa sambil terus memberdayakan ekosistem petani lokal demi masa depan industri kopi yang berkelanjutan.
                </p>
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
                    ['name' => 'Jeje', 'role' => 'Head Roaster', 'img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=400'],
                    ['name' => 'Sarah Jenkins', 'role' => 'Senior Barista', 'img' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=400'],
                    ['name' => 'Michael Chen', 'role' => 'Latte Art Specialist', 'img' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=400'],
                    ['name' => 'Emma Watson', 'role' => 'Coffee Sommelier', 'img' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=400'],
                    ['name' => 'David Miller', 'role' => 'Brew Master', 'img' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=400'],
                ];
            @endphp

            @foreach($staffs as $staff)
            <div class="min-w-70 md:min-w-[320px] snap-start group">
                {{-- Foto Staf --}}
                <div class="relative overflow-hidden aspect-3/4 mb-6 rounded-2xl shadow-sm group-hover:shadow-xl transition-all duration-500">
                    <img src="{{ $staff['img'] }}" 
                         class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700" 
                         alt="{{ $staff['name'] }}">
                    
                    <div class="absolute inset-0 bg-linear-to-t from-[#3C2A21]/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-8">
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

<style>
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 5s ease-in-out infinite;
    }
</style>
@endsection