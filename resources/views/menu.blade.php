@extends('layouts.app')

@section('content')
<section class="bg-[#FDFBF7] min-h-screen"> {{-- Warna Latar Cream Latte --}}

    {{-- 1. NAVIGASI KATEGORI --}}
    <div class="sticky top-18 z-40 bg-white/95 backdrop-blur-md border-b border-stone-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center gap-8 overflow-x-auto no-scrollbar py-4">
                @php
                    // Kita hanya butuh kategori, daftar $icons dihapus karena tidak dipakai lagi
                    $categories = $menus->pluck('kategori')->unique();
                @endphp

                {{-- Link Best Seller --}}
                @if($menus->where('is_best_seller', 1)->count() > 0)
                <a href="#best-seller" class="flex items-center gap-2 shrink-0 group">
                    {{-- Span ikon kosong atau dihapus --}}
                    <span class="text-sm font-bold text-stone-400 group-hover:text-[#A06040] transition duration-300 uppercase tracking-wider">Best Seller</span>
                </a>
                @endif

                {{-- Link Kategori Menu --}}
                @foreach($categories as $cat)
                <a href="#category-{{ Str::slug($cat) }}" class="flex items-center gap-2 shrink-0 group">
                    {{-- BAGIAN DIBAWAH INI SUDAH DIHAPUS (<span>{{ $icons[$cat] ?? '🍴' }}</span>) --}}
                    <span class="text-sm font-bold text-stone-400 group-hover:text-[#A06040] transition duration-300 uppercase tracking-wider">{{ $cat }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>
        </div>
    </div>

    {{-- 2. KONTEN MENU --}}
    <div class="max-w-7xl mx-auto px-6 py-16">
        
        {{-- BEST SELLER --}}
        @if($menus->where('is_best_seller', 1)->count() > 0)
        <div id="best-seller" class="mb-24 scroll-mt-40">
            <div class="flex items-center gap-4 mb-10">
                <h3 class="text-2xl font-black text-[#3C2A21] uppercase tracking-widest">Best Seller</h3>
                <div class="grow h-px bg-[#3C2A21]/10"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($menus->where('is_best_seller', 1) as $m)
                {{-- Data disimpan di atribut data-* untuk menghindari error VS Code --}}
                <div onclick="handleOpenModal(this)" 
                     data-nama="{{ $m->nama_menu }}"
                     data-deskripsi="{{ $m->deskripsi }}"
                     data-foto="{{ asset($m->foto) }}"
                     data-harga="{{ $m->harga }}"
                     data-id="{{ $m->id }}"
                     class="flex items-center gap-6 p-5 bg-white rounded-3xl border border-stone-200 hover:shadow-xl transition duration-500 group cursor-pointer">
                    <div class="w-28 h-28 shrink-0 overflow-hidden rounded-2xl bg-stone-50 shadow-inner">
                        <img src="{{ asset($m->foto) }}" class="w-full h-full object-contain group-hover:scale-110 transition duration-700" alt="{{ $m->nama_menu }}">
                    </div>
                    <div class="grow">
                        <h4 class="font-bold text-[#3C2A21] text-xl mb-1">{{ $m->nama_menu }}</h4>
                        <p class="text-[#A06040] font-black text-lg mb-4">Rp {{ number_format($m->harga, 0, ',', '.') }}</p>
                        <button type="button" onclick="event.stopPropagation(); addToCart('{{ $m->id }}')" class="bg-[#3C2A21] text-white px-6 py-2 rounded-full font-bold text-xs uppercase tracking-widest hover:bg-[#A06040] transition-colors shadow-lg shadow-stone-200">
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
                <div onclick="handleOpenModal(this)" 
                     data-nama="{{ $m->nama_menu }}"
                     data-deskripsi="{{ $m->deskripsi }}"
                     data-foto="{{ asset($m->foto) }}"
                     data-harga="{{ $m->harga }}"
                     data-id="{{ $m->id }}"
                     class="group bg-white p-4 rounded-3xl border border-transparent hover:border-stone-200 transition cursor-pointer">
                    <div class="relative aspect-square overflow-hidden rounded-2xl bg-stone-50 mb-6">
                        <img src="{{ asset($m->foto) }}" class="w-full h-full object-contain group-hover:scale-110 transition duration-500" alt="{{ $m->nama_menu }}">
                    </div>
                    <h3 class="text-lg font-bold text-[#3C2A21] mb-1">{{ $m->nama_menu }}</h3>
                    <p class="text-[#A06040] font-extrabold mb-4">Rp {{ number_format($m->harga, 0, ',', '.') }}</p>
                    
                    <button type="button" onclick="event.stopPropagation(); addToCart('{{ $m->id }}')"
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

{{-- 3. MODAL DESKRIPSI MENU --}}
<div id="menuModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/60 backdrop-blur-sm" onclick="closeMenuModal()"></div>

        {{-- Mengganti rounded-[2rem] ke rounded-4xl sesuai saran Tailwind --}}
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-4xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full animate-fade-in">
            <div class="p-8">
                <img id="modalImage" src="" class="w-full h-64 object-contain rounded-3xl mb-6 bg-stone-50">
                <h3 id="modalTitle" class="text-3xl font-black text-[#3C2A21] uppercase tracking-tighter mb-2"></h3>
                <p id="modalPrice" class="text-[#A06040] font-black text-xl mb-4"></p>
                <div class="h-px bg-stone-100 mb-4"></div>
                
                {{-- whitespace-pre-line menjaga format baris baru dari seeder --}}
                <p id="modalDescription" class="text-stone-500 leading-relaxed mb-8 font-light text-sm md:text-base whitespace-pre-line"></p>
                
                <div class="flex gap-4">
                    <button onclick="closeMenuModal()" class="flex-1 py-4 border-2 border-stone-200 text-stone-400 rounded-2xl font-bold uppercase tracking-widest hover:bg-stone-50 transition-all">
                        Tutup
                    </button>
                    {{-- Mengganti flex-[2] ke flex-2 sesuai saran Tailwind --}}
                    <button id="modalAddBtn" class="flex-2 py-4 bg-[#3C2A21] text-white rounded-2xl font-black uppercase tracking-widest hover:bg-[#A06040] shadow-lg transition-all">
                        + Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    body.modal-open { overflow: hidden; }
    .animate-fade-in { animation: fadeIn 0.3s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection

@push('scripts')
<script>
/**
 * Fungsi penengah untuk mengambil data dari atribut HTML
 * Ini mencegah error "Expression expected" di VS Code
 */
function handleOpenModal(element) {
    const title = element.getAttribute('data-nama');
    const desc = element.getAttribute('data-deskripsi');
    const img = element.getAttribute('data-foto');
    const price = element.getAttribute('data-harga');
    const id = element.getAttribute('data-id');

    openMenuModal(title, desc, img, price, id);
}

function openMenuModal(title, desc, img, price, id) {
    document.getElementById('modalTitle').innerText = title;
    
    const defaultDesc = 'Nikmati keharmonisan rasa dalam setiap hidangan yang kami sajikan sepenuh hati khas Valeria Coffee.';
    document.getElementById('modalDescription').innerText = desc || defaultDesc;
    
    document.getElementById('modalImage').src = img;
    document.getElementById('modalPrice').innerText = 'Rp ' + parseInt(price).toLocaleString('id-ID');
    
    const addBtn = document.getElementById('modalAddBtn');
    addBtn.onclick = () => {
        addToCart(id);
        closeMenuModal();
    };

    const modal = document.getElementById('menuModal');
    modal.classList.remove('hidden');
    document.body.classList.add('modal-open');
}

function closeMenuModal() {
    document.getElementById('menuModal').classList.add('hidden');
    document.body.classList.remove('modal-open');
}

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

        const data = await response.json();

        if (response.ok && data.success) {
            alert('Pesanan berhasil ditambahkan!');
            window.location.reload(); 
        } else {
            alert(data.error || 'Gagal menambahkan ke keranjang.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan koneksi.');
    }
}
</script>
@endpush