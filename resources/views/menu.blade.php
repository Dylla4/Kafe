@extends('layouts.app')

@section('content')
<section class="bg-[#FDFBF7]"> {{-- Warna Latar Cream Latte --}}
    {{-- 1. NAVIGASI KATEGORI STICKY --}}
    <div class="sticky top-18 z-40 bg-white/95 backdrop-blur-md border-b border-stone-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center gap-8 overflow-x-auto no-scrollbar py-4">
                @php
                    $categories = $menus->pluck('kategori')->unique();
                    $icons = [
                        'Coffee' => '☕',
                        'Frappe' => '🥤',
                        'Milk' => '🥛',
                        'Tea' => '🫖',
                        'Food' => '🍰'
                    ];
                @endphp

                @if($menus->where('is_best_seller', 1)->count() > 0)
                <a href="#best-seller" class="flex items-center gap-2 shrink-0 group">
                    <span class="text-xl">⭐️</span>
                    <span class="text-sm font-bold text-stone-400 group-hover:text-[#A06040] transition">Best Seller</span>
                </a>
                @endif

                @foreach($categories as $cat)
                <a href="#category-{{ Str::slug($cat) }}" class="flex items-center gap-2 shrink-0 group">
                    <span class="text-xl grayscale group-hover:grayscale-0 transition">{{ $icons[$cat] ?? '🍴' }}</span>
                    <span class="text-sm font-bold text-stone-400 group-hover:text-[#A06040] transition uppercase tracking-wider">{{ $cat }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- 2. KONTEN MENU --}}
    <div class="max-w-7xl mx-auto px-6 py-16">
        
        {{-- BEST SELLER --}}
        @if($menus->where('is_best_seller', 1)->count() > 0)
        <div id="best-seller" class="mb-24 scroll-mt-40">
            <div class="flex items-center gap-4 mb-10">
                <h3 class="text-2xl font-black text-[#3C2A21] uppercase tracking-widest">🔥 Best Seller</h3>
                <div class="grow h-px bg-[#3C2A21]/10"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($menus->where('is_best_seller', 1) as $m)
                <div class="flex items-center gap-6 p-5 bg-white rounded-3xl border border-stone-200 hover:shadow-xl transition duration-500 group">
                    <div class="w-28 h-28 shrink-0 overflow-hidden rounded-2xl bg-stone-50 shadow-inner">
                        <img src="{{ asset($m->foto) }}" class="w-full h-full object-contain group-hover:scale-110 transition duration-700" alt="{{ $m->nama_menu }}">
                    </div>
                    <div class="grow">
                        <h4 class="font-bold text-[#3C2A21] text-xl mb-1">{{ $m->nama_menu }}</h4>
                        <p class="text-[#A06040] font-black text-lg mb-4">Rp {{ number_format($m->harga) }}</p>
                        <button type="button" onclick="addToCart('{{ $m->id }}')" class="bg-[#3C2A21] text-white px-6 py-2 rounded-full font-bold text-xs uppercase tracking-widest hover:bg-[#A06040] transition-colors shadow-lg shadow-stone-200">
                            + Add to Cart
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- PER KATEGORI --}}
        @foreach($categories as $cat)
        <div class="mb-24 scroll-mt-40" id="category-{{ Str::slug($cat) }}">
            <div class="flex items-center gap-4 mb-10">
                <h3 class="text-2xl font-bold text-[#3C2A21] uppercase tracking-widest">{{ $cat }} Series</h3>
                <div class="grow h-px bg-stone-200"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-10">
                @foreach($menus->where('kategori', $cat) as $m)
                <div class="group bg-white p-4 rounded-3xl border border-transparent hover:border-stone-200 transition">
                    <div class="relative aspect-square overflow-hidden rounded-2xl bg-stone-50 mb-6">
                        <img src="{{ asset($m->foto) }}" class="w-full h-full object-contain group-hover:scale-110 transition duration-500" alt="{{ $m->nama_menu }}">
                    </div>
                    <h3 class="text-lg font-bold text-[#3C2A21] mb-1">{{ $m->nama_menu }}</h3>
                    <p class="text-[#A06040] font-extrabold mb-4">Rp {{ number_format($m->harga) }}</p>
                    
                    <button type="button" onclick="addToCart('{{ $m->id }}')"
                            class="w-full border-2 border-[#3C2A21] text-[#3C2A21] py-2 rounded-full font-bold text-xs uppercase tracking-widest hover:bg-[#3C2A21] hover:text-white transition shadow-sm">
                        Add to Cart
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</section>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection

@push('scripts')
<script>
async function addToCart(id) {
    try {
        const response = await fetch(`/cart/add/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

        if (response.ok) {
            alert('Menu berhasil ditambahkan!');
            window.location.reload(); 
        } else {
            alert('Gagal menambahkan ke keranjang.');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
</script>
@endpush