@extends('layouts.app')

@section('content')
<section class="bg-[#FDFBF7] min-h-screen"> {{-- Warna Latar Cream Latte --}}

    {{-- 1. NAVIGASI KATEGORI --}}
    <div class="sticky top-[72px] z-40 bg-white/95 backdrop-blur-md border-b border-stone-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center gap-8 overflow-x-auto no-scrollbar py-4">
                @php
                    $categories = $menus->pluck('kategori')->unique();
                @endphp

                {{-- Link Best Seller --}}
                @if($menus->where('is_best_seller', 1)->count() > 0)
                <a href="#best-seller" class="flex items-center gap-2 shrink-0 group">
                    <span class="text-sm font-bold text-stone-400 group-hover:text-[#A06040] transition duration-300 uppercase tracking-wider">Best Seller</span>
                </a>
                @endif

                {{-- Link Kategori Menu --}}
                @foreach($categories as $cat)
                <a href="#category-{{ Str::slug($cat) }}" class="flex items-center gap-2 shrink-0 group">
                    <span class="text-sm font-bold text-stone-400 group-hover:text-[#A06040] transition duration-300 uppercase tracking-wider">{{ $cat }}</span>
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
                <h3 class="text-2xl font-black text-[#3C2A21] uppercase tracking-widest">Best Seller</h3>
                <div class="grow h-px bg-[#3C2A21]/10"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($menus->where('is_best_seller', 1) as $m)
                @php
                    $cleanCategory = strtolower(trim($m->kategori));
                    $isMakanan = in_array($cleanCategory, ['makanan', 'sweet treats', 'snack', 'pastry']);
                @endphp
                
                <div @if($m->stok > 0) onclick="handleOpenModal(this)" @endif 
                     data-nama="{{ $m->nama_menu }}"
                     data-deskripsi="{{ $m->deskripsi }}"
                     data-foto="{{ asset($m->foto) }}"
                     data-harga="{{ $m->harga }}"
                     data-id="{{ $m->id }}"
                     data-stok="{{ $m->stok }}"
                     data-kategori="{{ $cleanCategory }}"
                     data-jenis="{{ $isMakanan ? 'makanan' : 'minuman' }}"
                     class="flex items-center gap-6 p-5 bg-white rounded-3xl border border-stone-200 hover:shadow-xl transition duration-500 group {{ $m->stok > 0 ? 'cursor-pointer' : 'opacity-60 cursor-not-allowed' }}">
                    <div class="w-28 h-28 shrink-0 overflow-hidden rounded-2xl bg-stone-50 shadow-inner relative">
                        <img src="{{ asset($m->foto) }}" class="w-full h-full object-contain @if($m->stok > 0) group-hover:scale-110 @endif transition duration-700" alt="{{ $m->nama_menu }}">
                        @if($m->stok <= 0)
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center"><span class="text-white text-xs font-bold uppercase tracking-wider">Habis</span></div>
                        @endif
                    </div>
                    <div class="grow">
                        <h4 class="font-bold text-[#3C2A21] text-xl mb-1">{{ $m->nama_menu }}</h4>
                        <p class="text-[#A06040] font-black text-lg mb-4">Rp {{ number_format($m->harga, 0, ',', '.') }}</p>
                        
                        @if($m->stok > 0)
                            <button type="button" onclick="event.stopPropagation(); handleOpenModal(this.closest('.cursor-pointer'))" class="bg-[#3C2A21] text-white px-6 py-2 rounded-full font-bold text-xs uppercase tracking-widest hover:bg-[#A06040] transition-colors shadow-lg shadow-stone-200">
                                + Add to Cart
                            </button>
                        @else
                            <button type="button" class="bg-stone-300 text-stone-500 px-6 py-2 rounded-full font-bold text-xs uppercase tracking-widest cursor-not-allowed" disabled>
                                Out of Stock
                            </button>
                        @endif
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

            <div class="grid grid-cols-2 md:grid-cols-5 gap-10">
                @foreach($menus->where('kategori', $cat) as $m)
                @php
                    $cleanCategory = strtolower(trim($m->kategori));
                    $isMakanan = in_array($cleanCategory, ['makanan', 'sweet treats', 'snack', 'pastry']);
                @endphp
                
                <div @if($m->stok > 0) onclick="handleOpenModal(this)" @endif 
                     data-nama="{{ $m->nama_menu }}"
                     data-deskripsi="{{ $m->deskripsi }}"
                     data-foto="{{ asset($m->foto) }}"
                     data-harga="{{ $m->harga }}"
                     data-id="{{ $m->id }}"
                     data-stok="{{ $m->stok }}"
                     data-kategori="{{ $cleanCategory }}"
                     data-jenis="{{ $isMakanan ? 'makanan' : 'minuman' }}"
                     class="group bg-white p-4 rounded-3xl border {{ $m->stok > 0 ? 'border-transparent hover:border-stone-200 cursor-pointer' : 'border-stone-100 opacity-60 cursor-not-allowed' }} transition">
                    <div class="relative aspect-square overflow-hidden rounded-2xl bg-stone-50 mb-6">
                        <img src="{{ asset($m->foto) }}" class="w-full h-full object-contain @if($m->stok > 0) group-hover:scale-110 @endif transition duration-500" alt="{{ $m->nama_menu }}">
                        @if($m->stok <= 0)
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center"><span class="text-white text-xs font-bold uppercase tracking-wider">Habis</span></div>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-[#3C2A21] mb-1">{{ $m->nama_menu }}</h3>
                    <p class="text-[#A06040] font-extrabold mb-4">Rp {{ number_format($m->harga, 0, ',', '.') }}</p>
                    
                    @if($m->stok > 0)
                        <button type="button" onclick="event.stopPropagation(); handleOpenModal(this.closest('.cursor-pointer'))"
                                class="w-full border-2 border-[#3C2A21] text-[#3C2A21] py-2 rounded-full font-bold text-xs uppercase tracking-widest hover:bg-[#3C2A21] hover:text-white transition shadow-sm">
                            Add to Cart
                        </button>
                    @else
                        <button type="button" class="w-full border-2 border-stone-200 text-stone-400 py-2 rounded-full font-bold text-xs uppercase tracking-widest cursor-not-allowed" disabled>
                            Sold Out
                        </button>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- 3. MODAL INTERAKTIF DETAIL MENU --}}
<div id="menuModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4 text-center">
        
        <div class="fixed inset-0 transition-opacity bg-black/60 backdrop-blur-sm" onclick="closeMenuModal()"></div>

        <div class="inline-block overflow-hidden text-left transition-all transform bg-white rounded-4xl shadow-xl w-full sm:max-w-lg animate-fade-in flex flex-col max-h-[85vh] z-10 mx-auto">
            
            <div class="flex items-center justify-between px-8 py-4 border-b border-stone-100">
                <div class="flex flex-col">
                    <h3 id="modalTitle" class="text-xl font-black text-[#3C2A21] uppercase tracking-wide">Detail Menu</h3>
                    <span id="modalStockDisplay" class="text-xs text-stone-400 mt-0.5"></span>
                </div>
                <button onclick="closeMenuModal()" class="text-stone-400 hover:text-stone-600 text-3xl font-light leading-none">&times;</button>
            </div>

            <div class="p-8 space-y-6 overflow-y-auto flex-1 no-scrollbar">
                
                {{-- Detail Produk --}}
                <div class="space-y-3">
                    <img id="modalImage" src="" class="w-full h-64 object-contain rounded-3xl bg-stone-50 shadow-sm">
                    <p id="modalPriceHeader" class="text-[#A06040] font-black text-2xl"></p>
                    <p id="modalDescription" class="text-stone-500 leading-relaxed font-light text-sm whitespace-pre-line"></p>
                </div>

                <form id="addToCartForm" onsubmit="handleFormSubmit(event)" class="space-y-6">
                    <input type="hidden" id="modalMenuId" name="menu_id">

                    {{-- Opsi Tipe Menu (Hot / Ice) --}}
                    <div id="menuTypeOptions" class="space-y-3 hidden">
                        <h4 class="font-bold text-[#3C2A21] text-xs uppercase tracking-widest text-stone-400">Pilihan Menu (Optional)</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center justify-between p-3.5 border border-stone-200 rounded-2xl cursor-pointer hover:bg-stone-50/50 transition">
                                <span class="text-sm font-medium text-stone-700">Hot</span>
                                <input type="radio" name="pilihan_menu" value="Hot" class="w-4 h-4 text-[#3C2A21] focus:ring-[#3C2A21] border-stone-300">
                            </label>
                            <label class="flex items-center justify-between p-3.5 border border-stone-200 rounded-2xl cursor-pointer hover:bg-stone-50/50 transition">
                                <span class="text-sm font-medium text-stone-700">Ice</span>
                                <input type="radio" name="pilihan_menu" value="Ice" checked class="w-4 h-4 text-[#3C2A21] focus:ring-[#3C2A21] border-stone-300">
                            </label>
                        </div>
                    </div>

                    {{-- Pembungkus Level Es & Gula --}}
                    <div id="beverageOptions" class="space-y-6 hidden">
                        {{-- Opsi 1: Level Es --}}
                        <div class="space-y-3">
                            <h4 class="font-bold text-[#3C2A21] text-xs uppercase tracking-widest text-stone-400">Level Es (Optional)</h4>
                            <div class="space-y-2">
                                <label class="flex items-center justify-between p-3.5 border border-stone-100 rounded-2xl cursor-pointer hover:bg-stone-50/50 transition">
                                    <span class="text-sm font-medium text-stone-700">Normal Ice</span>
                                    <input type="radio" name="level_es" value="Normal Ice" checked class="w-4 h-4 text-[#3C2A21] focus:ring-[#3C2A21] border-stone-300">
                                </label>
                                <label class="flex items-center justify-between p-3.5 border border-stone-100 rounded-2xl cursor-pointer hover:bg-stone-50/50 transition">
                                    <span class="text-sm font-medium text-stone-700">Less Ice</span>
                                    <input type="radio" name="level_es" value="Less Ice" class="w-4 h-4 text-[#3C2A21] focus:ring-[#3C2A21] border-stone-300">
                                </label>
                                <label class="flex items-center justify-between p-3.5 border border-stone-100 rounded-2xl cursor-pointer hover:bg-stone-50/50 transition">
                                    <span class="text-sm font-medium text-stone-700">No Ice</span>
                                    <input type="radio" name="level_es" value="No Ice" class="w-4 h-4 text-[#3C2A21] focus:ring-[#3C2A21] border-stone-300">
                                </label>
                            </div>
                        </div>

                        {{-- Opsi 2: Level Kemanisan --}}
                        <div class="space-y-3">
                            <h4 class="font-bold text-[#3C2A21] text-xs uppercase tracking-widest text-stone-400">Level Kemanisan (Optional)</h4>
                            <div class="space-y-2">
                                <label class="flex items-center justify-between p-3.5 border border-stone-100 rounded-2xl cursor-pointer hover:bg-stone-50/50 transition">
                                    <span class="text-sm font-medium text-stone-700">Normal Sugar</span>
                                    <input type="radio" name="level_gula" value="Normal Sugar" checked class="w-4 h-4 text-[#3C2A21] focus:ring-[#3C2A21] border-stone-300">
                                </label>
                                <label class="flex items-center justify-between p-3.5 border border-stone-100 rounded-2xl cursor-pointer hover:bg-stone-50/50 transition">
                                    <span class="text-sm font-medium text-stone-700">Less Sugar</span>
                                    <input type="radio" name="level_gula" value="Less Sugar" class="w-4 h-4 text-[#3C2A21] focus:ring-[#3C2A21] border-stone-300">
                                </label>
                                <label class="flex items-center justify-between p-3.5 border border-stone-100 rounded-2xl cursor-pointer hover:bg-stone-50/50 transition">
                                    <span class="text-sm font-medium text-stone-700">No Sugar</span>
                                    <input type="radio" name="level_gula" value="No Sugar" class="w-4 h-4 text-[#3C2A21] focus:ring-[#3C2A21] border-stone-300">
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Note / Catatan --}}
                    <div class="space-y-2">
                        <h4 class="font-bold text-[#3C2A21] text-xs uppercase tracking-widest text-stone-400">Note to Restaurant (Optional)</h4>
                        <textarea name="catatan" id="modalNote" rows="2" placeholder="Add your request (subject to restaurant's discretion)" class="w-full px-4 py-3 border border-stone-200 rounded-2xl text-sm focus:outline-none focus:border-[#3C2A21] focus:ring-1 focus:ring-[#3C2A21] text-stone-700 resize-none placeholder-stone-400"></textarea>
                    </div>
                </form>
            </div>

            <div class="p-6 border-t border-stone-100 bg-stone-50/80 flex items-center gap-4">
                {{-- Kuantitas --}}
                <div class="flex items-center bg-white border border-stone-200 rounded-full px-2 py-1 shadow-sm">
                    <button type="button" onclick="changeQuantity(-1)" class="w-9 h-9 flex items-center justify-center font-bold text-stone-500 hover:text-stone-800 text-xl transition-all">&minus;</button>
                    <span id="modalQtyDisplay" class="font-bold text-[#3C2A21] w-8 text-center text-base">1</span>
                    <button type="button" onclick="changeQuantity(1)" class="w-9 h-9 flex items-center justify-center font-bold text-stone-500 hover:text-stone-800 text-xl transition-all">&plus;</button>
                </div>
                
                {{-- Tombol Submit --}}
                <button type="submit" form="addToCartForm" class="flex-1 bg-[#3C2A21] hover:bg-[#A06040] text-white font-bold py-4 px-6 rounded-full transition-all duration-300 shadow-md flex justify-between items-center text-sm uppercase tracking-wider">
                    <span>Add to Basket</span>
                    <span id="modalTotalPriceDisplay">Rp 0</span>
                </button>
            </div>

        </div>
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    body.modal-open { overflow: hidden; }
    .animate-fade-in { animation: fadeIn 0.25s cubic-bezier(0.16, 1, 0.3, 1); }
    @keyframes fadeIn { from { opacity: 0; transform: scale(0.95) translateY(10px); } to { opacity: 1; transform: scale(1) translateY(0); } }
</style>
@endsection

@push('scripts')
<script>
let currentItemPrice = 0;
let currentQuantity = 1;
let currentItemStock = 0;

function handleOpenModal(element) {
    const title = element.getAttribute('data-nama');
    const desc = element.getAttribute('data-deskripsi');
    const img = element.getAttribute('data-foto');
    const price = parseInt(element.getAttribute('data-harga'));
    const id = element.getAttribute('data-id');
    const stok = parseInt(element.getAttribute('data-stok')) || 0;
    const jenis = element.getAttribute('data-jenis');
    const kategori = element.getAttribute('data-kategori') || '';
    const namaMenuUpper = title.toUpperCase();
    
    if(stok <= 0) {
        alert('Maaf, menu ini sedang tidak tersedia.');
        return;
    }

    currentItemPrice = price;
    currentQuantity = 1;
    currentItemStock = stok;

    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalStockDisplay').innerText = `Sisa Stok: ${stok} porsi`;
    document.getElementById('modalImage').src = img;
    document.getElementById('modalMenuId').value = id;
    
    const defaultDesc = 'Hadirkan suasana istimewa dalam setiap hidangan pilihan matang sempurna khas Valeria Coffee.';
    document.getElementById('modalDescription').innerText = desc || defaultDesc;
    
    document.getElementById('modalPriceHeader').innerText = 'Rp ' + price.toLocaleString('id-ID');
    document.getElementById('modalQtyDisplay').innerText = currentQuantity;

    // Reset form agar kembali ke kondisi default (Opsi Ice terpilih)
    document.getElementById('addToCartForm').reset();

    const beverageOptions = document.getElementById('beverageOptions');
    const menuTypeOptions = document.getElementById('menuTypeOptions');

    // PENYARINGAN KATEGORI & JENIS YANG JAUH LEBIH KUAT
    if (jenis === 'makanan' || kategori.includes('makanan') || kategori.includes('treats') || kategori.includes('snack') || kategori.includes('pastry')) {
        beverageOptions.classList.add('hidden');
        menuTypeOptions.classList.add('hidden');
    } else {
        beverageOptions.classList.remove('hidden');

        // Deteksi untuk menampilkan opsi Hot / Ice pada Coffee Series
        if (kategori.includes('coffee') || kategori.includes('kopi') || namaMenuUpper.includes('AMERICANO') || namaMenuUpper.includes('ESPRESSO') || namaMenuUpper.includes('LATTE')) {
            menuTypeOptions.classList.remove('hidden');
        } else {
            menuTypeOptions.classList.add('hidden');
        }
    }

    // PENTING: Jalankan sinkronisasi harga dan visual opsi ES saat modal terbuka
    updateTotalPrice();
    toggleIceOptions();

    const modal = document.getElementById('menuModal');
    modal.classList.remove('hidden');
    document.body.classList.add('modal-open');
}

function closeMenuModal() {
    document.getElementById('menuModal').classList.add('hidden');
    document.body.classList.remove('modal-open');
}

function changeQuantity(amount) {
    currentQuantity += amount;
    if (currentQuantity < 1) currentQuantity = 1; 
    if (currentQuantity > currentItemStock) {
        alert(`Maaf, kamu hanya bisa memesan maksimal ${currentItemStock} porsi.`);
        currentQuantity = currentItemStock;
    }
    document.getElementById('modalQtyDisplay').innerText = currentQuantity;
    updateTotalPrice();
}

function updateTotalPrice() {
    let total = currentItemPrice * currentQuantity;
    document.getElementById('modalTotalPriceDisplay').innerText = 'Rp ' + total.toLocaleString('id-ID');
}

function toggleIceOptions() {
    const pilihanMenuRadio = document.querySelector('input[name="pilihan_menu"]:checked');
    const iceOptionsWrapper = document.querySelector('input[name="level_es"]').closest('.space-y-3');

    if (pilihanMenuRadio && pilihanMenuRadio.value === 'Hot') {
        // Jika milih Hot, sembunyikan container Level Es
        iceOptionsWrapper.classList.add('hidden');
    } else {
        // Jika milih Ice, pastikan container Level Es tampil, dengan syarat pembungkus utamanya tidak hidden
        const beverageOptions = document.getElementById('beverageOptions');
        if (!beverageOptions.classList.contains('hidden')) {
            iceOptionsWrapper.classList.remove('hidden');
        }
    }
}

// Deteksi perubahan klik pada radio button Hot / Ice secara real-time
document.querySelectorAll('input[name="pilihan_menu"]').forEach(radio => {
    radio.addEventListener('change', toggleIceOptions);
});

function handleFormSubmit(event) {
    event.preventDefault();
    
    const menuId = document.getElementById('modalMenuId').value;
    const form = document.getElementById('addToCartForm');
    const formData = new FormData(form);

    const isBeverageHidden = document.getElementById('beverageOptions').classList.contains('hidden');
    const isTypeHidden = document.getElementById('menuTypeOptions').classList.contains('hidden');
    
    // Cari tahu apakah wrapper es sedang di-hidden oleh fungsi toggleIceOptions
    const iceOptionsWrapper = document.querySelector('input[name="level_es"]').closest('.space-y-3');
    const isIceHidden = iceOptionsWrapper.classList.contains('hidden');

    const payload = {
        quantity: currentQuantity,
        // PERBAIKAN: Jika bunderan level es di-hidden (karena milih Hot atau karena menu Makanan), kirim '-'
        level_es: (isBeverageHidden || isIceHidden) ? '-' : (formData.get('level_es') || 'Normal Ice'),
        level_gula: isBeverageHidden ? '-' : (formData.get('level_gula') || 'Normal Sugar'),
        pilihan_menu: isTypeHidden ? '-' : (formData.get('pilihan_menu') || 'Ice'),
        catatan: formData.get('catatan') || '',
    };

    executeAddToCart(menuId, payload);
}

async function executeAddToCart(id, payload) {
    try {
        const response = await fetch(`/cart/add/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (response.ok && data.success) {
            alert('Pesanan berhasil dimasukkan ke basket!');
            closeMenuModal();
            window.location.reload(); 
        } else {
            alert(data.error || 'Gagal menambahkan item ke keranjang.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kendala saat menghubungkan ke server.');
    }
}
</script>
@endpush