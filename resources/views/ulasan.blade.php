@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Ulasan Pelanggan</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-4 mb-6 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('ulasan.store') }}" method="POST" class="mb-10 p-6 bg-white shadow-lg rounded-xl border border-gray-100">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="nama" placeholder="Masukkan nama Anda" 
                   class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-[#A06040] focus:border-transparent outline-none transition" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Pesan Ulasan</label>
            <textarea name="komentar" rows="3" placeholder="Bagaimana pengalaman Anda di Valeria Coffee?" 
                      class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-[#A06040] focus:border-transparent outline-none transition" required></textarea>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Rating Anda:</label>
            <div class="flex flex-row-reverse justify-end gap-2" id="star-rating">
                @for ($i = 5; $i >= 1; $i--)
                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden" required>
                    <label for="star{{ $i }}" class="cursor-pointer text-4xl text-gray-300 hover:text-yellow-400 transition-colors duration-200">
                        ★
                    </label>
                @endfor
            </div>
        </div>

        <button type="submit" class="bg-[#A06040] text-white px-8 py-3 rounded-lg shadow-md hover:bg-[#804c33] transform hover:-translate-y-0.5 transition-all duration-200 font-bold">
            Kirim Ulasan Sekarang
        </button>
    </form>

    <hr class="mb-10 border-gray-200">

    <div class="space-y-8">
        @forelse($ulasans as $u)
            <div class="p-6 bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                    <div>
                        <h4 class="font-bold text-gray-900 text-xl flex items-center gap-2">
                            {{ $u->nama }}
                        </h4>
                        <div class="flex text-2xl mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $u->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                            @endfor
                        </div>
                    </div>

                    <div class="text-left md:text-right">
                        <p class="text-sm font-semibold text-gray-600">
                            {{ \Carbon\Carbon::parse($u->created_at)->locale('id')->translatedFormat('d F Y') }}
                        </p>
                        <p class="text-xs text-gray-400 italic">
                            {{ \Carbon\Carbon::parse($u->created_at)->locale('id')->diffForHumans() }}
                        </p>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg italic text-gray-700 leading-relaxed border-l-4 border-[#A06040]">
                    "{{ $u->komentar }}"
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-gray-500">
                Belum ada ulasan. Jadilah yang pertama memberikan ulasan!
            </div>
        @endforelse
    </div>
</div>

<style>
    /* Logika CSS untuk sistem rating bintang */
    #star-rating label:hover,
    #star-rating label:hover ~ label { color: #fbbf24 !important; }
    #star-rating input:checked ~ label { color: #fbbf24 !important; }
</style>
@endsection