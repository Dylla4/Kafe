@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-6">
    <h2 class="text-3xl font-bold mb-6">Ulasan Pelanggan</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <form action="{{ route('ulasan.store') }}" method="POST" class="mb-10 p-6 bg-white shadow rounded">
        @csrf
        <div class="mb-4">
            <input type="text" name="nama" placeholder="Nama Anda" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <textarea name="komentar" placeholder="Tulis ulasan Anda..." class="w-full border p-2 rounded" required></textarea>
        </div>
        
        <div class="mb-4">
            <label class="block font-bold mb-2">Rating:</label>
            <div class="flex flex-row-reverse justify-end gap-1" id="star-rating">
                @for ($i = 5; $i >= 1; $i--)
                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden" required>
                    <label for="star{{ $i }}" class="cursor-pointer text-3xl text-gray-300 transition-colors duration-200">
                        ★
                    </label>
                @endfor
            </div>
        </div>

        <button type="submit" class="bg-[#A06040] text-white px-4 py-2 rounded hover:bg-[#804c33] transition">Kirim Ulasan</button>
    </form>

    <div class="grid gap-4">
        @foreach($ulasans as $u)
            <div class="p-4 border-b">
                <h4 class="font-bold">
                    {{ $u->nama }} 
                    <span class="text-yellow-400 ml-2 text-xl">
                        {{ str_repeat('★', $u->rating) }}
                    </span>
                </h4>
                <p class="text-gray-600">{{ $u->komentar }}</p>
            </div>
        @endforeach
    </div>
</div>

<style>
    #star-rating label:hover,
    #star-rating label:hover ~ label { color: #fbbf24; }
    #star-rating input:checked ~ label { color: #fbbf24; }
</style>
@endsection