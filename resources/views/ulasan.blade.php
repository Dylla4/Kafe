@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Ulasan Pelanggan</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-4 mb-6 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Utama --}}
    <form action="{{ route('ulasan.store') }}" method="POST" enctype="multipart/form-data"
          class="mb-10 p-8 bg-white shadow-xl rounded-2xl border border-gray-100">
        @csrf
        
        {{-- ID Pesanan Tersembunyi - Sangat Penting! --}}
        <input type="hidden" name="order_id" value="{{ $order->id }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="nama" 
                        value="{{ auth()->user()->name }}" 
                        class="w-full border border-gray-300 p-3 rounded-xl bg-gray-50 cursor-not-allowed outline-none" 
                        readonly required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Pesanan</label>
                <input type="text" value="#VAL-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}" 
                        class="w-full border border-gray-300 p-3 rounded-xl bg-gray-50 cursor-not-allowed outline-none" 
                        readonly>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Rating Anda:</label>
            <div class="flex flex-row-reverse justify-end gap-2" id="star-rating">
                <input type="radio" id="star5" name="rating" value="5" class="hidden" required>
                <label for="star5" class="cursor-pointer text-4xl text-gray-300 hover:text-yellow-400 transition-colors">★</label>
                
                <input type="radio" id="star4" name="rating" value="4" class="hidden">
                <label for="star4" class="cursor-pointer text-4xl text-gray-300 hover:text-yellow-400 transition-colors">★</label>
                
                <input type="radio" id="star3" name="rating" value="3" class="hidden">
                <label for="star3" class="cursor-pointer text-4xl text-gray-300 hover:text-yellow-400 transition-colors">★</label>
                
                <input type="radio" id="star2" name="rating" value="2" class="hidden">
                <label for="star2" class="cursor-pointer text-4xl text-gray-300 hover:text-yellow-400 transition-colors">★</label>
                
                <input type="radio" id="star1" name="rating" value="1" class="hidden">
                <label for="star1" class="cursor-pointer text-4xl text-gray-300 hover:text-yellow-400 transition-colors">★</label>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Pesan Ulasan</label>
            <textarea name="komentar" rows="4" placeholder="Bagaimana pengalaman Anda di Valeria Coffee?"
                      class="w-full border border-gray-300 p-4 rounded-xl focus:ring-2 focus:ring-[#A06040] outline-none transition" required></textarea>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Foto (Opsional)</label>
            <input type="file" name="foto" id="foto-input-ulasan" accept="image/*"
                   class="w-full border border-gray-300 p-2 rounded-xl text-sm file:mr-4 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-[#A06040] file:text-white hover:file:bg-[#804c33] cursor-pointer shadow-sm">
            
            <div id="preview-container-ulasan" class="mt-4 hidden">
                <p class="text-xs text-gray-500 mb-2 font-medium">Preview Gambar:</p>
                <img id="preview-img-ulasan" class="w-40 h-40 object-cover rounded-2xl border-2 border-dashed border-gray-200 p-1">
            </div>
            @error('foto')
                <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full bg-[#3C2A21] text-white py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-black transition-all shadow-lg active:scale-95">
            Kirim Ulasan Sekarang
        </button>
    </form>

    <div class="flex items-center gap-4 mb-10">
        <div class="h-[1px] bg-gray-200 flex-1"></div>
        <span class="text-gray-400 font-bold text-xs uppercase tracking-widest">Ulasan Lainnya</span>
        <div class="h-[1px] bg-gray-200 flex-1"></div>
    </div>

    {{-- Daftar Ulasan --}}
    <div class="space-y-8">
        @forelse($ulasans as $u)
            <div class="p-6 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md transition duration-300">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-4">
                    <div>
                        <h4 class="font-black text-gray-900 text-xl tracking-tight">{{ $u->nama }}</h4>
                        <div class="flex text-2xl mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $u->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                            @endfor
                        </div>
                    </div>
                    <div class="text-left md:text-right">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                            {{ $u->created_at->translatedFormat('d F Y') }}
                        </p>
                        <p class="text-[10px] text-gray-400 italic mt-1">
                            {{ $u->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>

                <div class="bg-stone-50 p-5 rounded-2xl italic text-stone-700 border-l-4 border-[#A06040] mb-4 text-lg">
                    "{{ $u->komentar }}"
                </div>

                @if($u->foto)
                    <div class="mt-4">
                        <a href="{{ asset('storage/' . $u->foto) }}" target="_blank" class="inline-block group">
                            <img src="{{ asset('storage/' . $u->foto) }}" 
                                 class="w-56 h-56 object-cover rounded-2xl shadow-sm group-hover:scale-105 transition duration-300 cursor-zoom-in border border-gray-100"
                                 alt="Foto ulasan {{ $u->nama }}">
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-16 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                <p class="text-gray-400 italic font-medium">Belum ada ulasan untuk Valeria Coffee.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    #star-rating input:checked ~ label,
    #star-rating label:hover,
    #star-rating label:hover ~ label {
        color: #fbbf24 !important;
    }
</style>

<script>
    const ulasanFotoInput = document.getElementById('foto-input-ulasan');
    const ulasanPreviewContainer = document.getElementById('preview-container-ulasan');
    const ulasanPreviewImg = document.getElementById('preview-img-ulasan');

    ulasanFotoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            ulasanPreviewContainer.classList.remove('hidden');
            reader.onload = function(e) {
                ulasanPreviewImg.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            ulasanPreviewContainer.classList.add('hidden');
        }
    });
</script>
@endsection