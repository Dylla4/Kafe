@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<section class="py-20 bg-white px-6">
  <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
    <div class="flex justify-center">
      <img src="{{ asset('img/poto.jpg') }}" alt="Tentang Valeria Coffee"
           class="rounded-3xl shadow-2xl w-full max-w-md object-cover hover:scale-105 transition duration-500">
    </div>

    <div class="space-y-6">
      <h2 class="text-4xl md:text-5xl font-bold text-stone-800 leading-tight">
        Cerita Dibalik <span class="text-orange-700">Valeria Coffee</span>
      </h2>
      <p class="text-lg text-stone-600 leading-relaxed">
        Valeria Coffee bukan sekadar tempat minum kopi. Kami adalah ruang di mana cita rasa bertemu dengan kenyamanan. Berawal dari kecintaan pada biji kopi lokal, kami menghadirkan seduhan manual yang diproses dengan hati.
      </p>
      <div class="bg-orange-50 p-6 rounded-2xl border-l-4 border-orange-700">
        <p class="italic text-stone-700">"Setiap tegukan adalah cerita tentang dedikasi barista kami untuk memberikan yang terbaik bagi Anda."</p>
      </div>
    </div>
  </div>
</section>
@endsection