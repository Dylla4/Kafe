@extends('layouts.app')

@section('content')
{{-- Tambahkan Font Montserrat untuk kesan modern jika belum ada --}}
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">

<div class="max-w-4xl mx-auto py-12 px-6 font-['Montserrat']">
    {{-- Header Section --}}
    <div class="text-center mb-12">
        <h2 class="text-4xl font-black text-[#3C2A21] tracking-tighter uppercase mb-2">Ulasan Pelanggan</h2>
        <p class="text-gray-500 font-medium">Ceritakan momen kopi Anda di Valeria Coffee</p>
        <div class="w-20 h-1 bg-[#A06040] mx-auto mt-4 rounded-full"></div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 mb-8 rounded-xl shadow-sm flex justify-between items-center animate-bounce">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700 transition">&times;</button>
        </div>
    @endif

    {{-- Form Section --}}
    @isset($order)
    <div class="relative mb-16">
        <div class="absolute -top-4 -left-4 w-24 h-24 bg-[#A06040]/10 rounded-full -z-10"></div>
        <form action="{{ route('ulasan.store') }}" method="POST" enctype="multipart/form-data"
              class="p-8 md:p-10 bg-white/80 backdrop-blur-md shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-[2.5rem] border border-white">
            @csrf
            
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-[#3C2A21]">Nama Pelanggan</label>
                    <input type="text" name="nama" value="{{ auth()->user()->name ?? 'Tamu' }}" 
                           class="w-full bg-stone-100 border-none p-4 rounded-2xl text-stone-500 font-bold focus:ring-0 cursor-not-allowed" readonly>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-[#3C2A21]">Nomor Pesanan</label>
                    <div class="bg-stone-100 p-4 rounded-2xl text-[#A06040] font-black">
                        #VAL-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                    </div>
                </div>
            </div>

            <div class="mb-8 text-center">
                <label class="block text-xs font-black uppercase tracking-widest text-[#3C2A21] mb-4">Berikan Rating</label>
                <div class="flex flex-row-reverse justify-center gap-3" id="star-rating">
                    @for($i = 5; $i >= 1; $i--)
                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden" required>
                        <label for="star{{ $i }}" class="cursor-pointer text-5xl text-stone-200 hover:text-[#fbbf24] transition-all duration-300 transform hover:scale-125">★</label>
                    @endfor
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-xs font-black uppercase tracking-widest text-[#3C2A21] mb-2">Ceritakan Pengalaman Anda</label>
                <textarea name="komentar" rows="4" placeholder="Kopi yang nikmat, suasana yang hangat..."
                          class="w-full bg-stone-50 border-2 border-stone-100 p-5 rounded-[1.5rem] focus:border-[#A06040] focus:ring-0 transition-all outline-none italic">{{ old('komentar') }}</textarea>
            </div>

            <div class="mb-10">
                <label class="block text-xs font-black uppercase tracking-widest text-[#3C2A21] mb-2">Lampirkan Foto (Opsional)</label>
                <div class="flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-stone-200 rounded-[1.5rem] cursor-pointer bg-stone-50 hover:bg-stone-100 transition">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 text-stone-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p class="text-sm text-stone-400 font-medium">Klik untuk upload foto</p>
                        </div>
                        <input type="file" name="foto" id="foto-input-ulasan" accept="image/*" class="hidden">
                    </label>
                </div>
                <div id="preview-container-ulasan" class="mt-4 hidden text-center">
                    <img id="preview-img-ulasan" class="inline-block w-32 h-32 object-cover rounded-2xl border-4 border-white shadow-lg">
                </div>
            </div>

            <button type="submit" class="w-full bg-[#3C2A21] text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-black transition-all shadow-xl active:scale-95">
                Kirim Ulasan Premium
            </button>
        </form>
    </div>
    @else
    <div class="mb-16 p-10 bg-gradient-to-br from-amber-50 to-stone-100 rounded-[2.5rem] text-center border border-amber-100">
        <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
            <svg class="w-8 h-8 text-[#A06040]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>
        <h3 class="text-xl font-black text-[#3C2A21] mb-2 uppercase">Ingin Berbagi Pengalaman?</h3>
        <p class="text-stone-500 mb-6 font-medium">Pilih pesanan Anda di riwayat belanja untuk menulis ulasan.</p>
        <a href="/history" class="px-8 py-3 bg-[#A06040] text-white font-black rounded-full uppercase text-xs tracking-widest hover:bg-[#804c33] transition-all shadow-lg">
            Buka Riwayat Pesanan
        </a>
    </div>
    @endisset

    {{-- Divider --}}
    <div class="relative flex items-center gap-4 mb-16">
        <div class="h-[2px] bg-stone-100 flex-1"></div>
        <span class="text-[#A06040] font-black text-[10px] uppercase tracking-[0.5em] px-4">Kesan Mereka</span>
        <div class="h-[2px] bg-stone-100 flex-1"></div>
    </div>

    {{-- Daftar Ulasan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($ulasan as $u)
            <div class="group bg-white p-8 rounded-[2rem] border border-stone-50 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                <div class="flex justify-between items-start mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-[#3C2A21] rounded-full flex items-center justify-center text-white font-black text-lg">
                            {{ substr($u->nama, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-black text-[#3C2A21] leading-none">{{ $u->nama }}</h4>
                            <span class="text-[9px] font-bold text-stone-400 uppercase tracking-tighter">ORDER #VAL-{{ str_pad($u->order_id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                    <div class="flex text-sm">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $u->rating ? 'text-[#fbbf24]' : 'text-stone-100' }}">★</span>
                        @endfor
                    </div>
                </div>

                <div class="relative mb-6">
                    <span class="absolute -top-4 -left-2 text-stone-100 text-6xl font-serif">“</span>
                    <p class="relative text-stone-600 font-medium leading-relaxed italic">
                        {{ $u->komentar }}
                    </p>
                </div>

                @if($u->foto)
                    <div class="relative overflow-hidden rounded-2xl group-hover:shadow-lg transition-all duration-500">
                        <img src="{{ asset('storage/' . $u->foto) }}" 
                             class="w-full h-48 object-cover transform group-hover:scale-110 transition-all duration-700">
                    </div>
                @endif
                
                <div class="mt-6 pt-4 border-t border-stone-50 flex justify-between items-center text-[10px] font-bold text-stone-300 uppercase tracking-widest">
                    <span>Valeria Guest</span>
                    <span>{{ $u->created_at->diffForHumans() }}</span>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-stone-50 rounded-[3rem] border-2 border-dashed border-stone-200">
                <div class="text-stone-300 mb-4 text-6xl">☕</div>
                <p class="text-stone-400 font-bold uppercase tracking-widest italic text-sm">Jadilah yang pertama memberikan ulasan</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    /* Star Rating Logic */
    #star-rating input:checked ~ label,
    #star-rating label:hover,
    #star-rating label:hover ~ label {
        color: #fbbf24 !important;
    }
    /* Smooth Preview Animation */
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    #preview-container-ulasan { animation: fadeIn 0.5s ease forwards; }
</style>

<script>
    const input = document.getElementById('foto-input-ulasan');
    const previewContainer = document.getElementById('preview-container-ulasan');
    const previewImg = document.getElementById('preview-img-ulasan');

    input.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            previewContainer.classList.remove('hidden');
            reader.onload = function(e) { previewImg.src = e.target.result; }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection