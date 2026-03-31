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
          class="mb-10 p-6 bg-white shadow-lg rounded-xl border border-gray-100">
        @csrf
        
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="nama" placeholder="Masukkan nama Anda"
                   class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-[#A06040] outline-none" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Pesan Ulasan</label>
            <textarea name="komentar" rows="3" placeholder="Bagaimana pengalaman Anda di Valeria Coffee?"
                      class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-[#A06040] outline-none" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Upload Foto</label>
            {{-- Tambahkan id unik dan pastikan name="foto" --}}
            <input type="file" name="foto" id="foto-input-ulasan" accept="image/*"
                   class="w-full border border-gray-300 p-2 rounded-lg text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#A06040] file:text-white hover:file:bg-[#804c33] cursor-pointer">
            
            {{-- Preview Foto --}}
            <div id="preview-container-ulasan" class="mt-3 hidden">
                <p class="text-xs text-gray-500 mb-1">Preview Gambar:</p>
                <img id="preview-img-ulasan" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
            </div>
            @error('foto')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Rating Anda:</label>
            <div class="flex flex-row-reverse justify-end gap-2" id="star-rating">
                {{-- Urutan input radio sangat penting untuk efek CSS flex-row-reverse --}}
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

        <button type="submit" class="w-full md:w-auto bg-[#A06040] text-white px-8 py-3 rounded-lg shadow-md hover:bg-[#804c33] transition font-bold">
            Kirim Ulasan Sekarang
        </button>
    </form>

    <hr class="mb-10 border-gray-200">

    {{-- Daftar Ulasan --}}
    <div class="space-y-8">
        @forelse($ulasans as $u)
            <div class="p-6 bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-4">
                    <div>
                        <h4 class="font-bold text-gray-900 text-xl">{{ $u->nama }}</h4>
                        <div class="flex text-2xl mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $u->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                            @endfor
                        </div>
                    </div>
                    <div class="text-left md:text-right">
                        <p class="text-sm font-semibold text-gray-600">
                            {{ $u->created_at->translatedFormat('d F Y') }}
                        </p>
                        <p class="text-xs text-gray-400 italic">
                            {{ $u->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg italic text-gray-700 border-l-4 border-[#A06040] mb-4">
                    "{{ $u->komentar }}"
                </div>

                {{-- Logic Menampilkan Foto --}}
                @if($u->foto)
                    <div class="mt-4">
                        {{-- Menggunakan path storage yang benar --}}
                        <a href="{{ asset('storage/' . $u->foto) }}" target="_blank" class="inline-block group">
                            <img src="{{ asset('storage/' . $u->foto) }}" 
                                 class="w-48 h-48 object-cover rounded-xl shadow-md group-hover:scale-105 transition cursor-zoom-in border border-gray-200"
                                 alt="Foto ulasan {{ $u->nama }}">
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-10 text-gray-500 italic">Belum ada ulasan untuk Valeria Coffee.</div>
        @endforelse
    </div>
</div>

<style>
    /* Bintang yang dipilih dan bintang sebelumnya akan berwarna kuning */
    #star-rating input:checked ~ label,
    #star-rating label:hover,
    #star-rating label:hover ~ label {
        color: #fbbf24 !important;
    }
</style>

<script>
    // Preview Foto dengan ID yang diperbarui
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