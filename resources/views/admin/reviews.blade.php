@extends('layouts.admin')

@section('content')
<main class="p-8 lg:p-12 w-full bg-[#FDFCFB] min-h-screen">
    <!-- Header -->
    <header class="flex justify-between items-end mb-10 w-full">
        <div>
            <h2 class="text-5xl font-black text-[#2D2018] tracking-tighter uppercase italic leading-none">Reviews Pesanan</h2>
            <p class="text-stone-400 text-base font-medium mt-2">Kelola semua reviews dari pelanggan di sini.</p>
        </div>
        <div class="text-right">
            <p class="text-xs font-black text-stone-400 uppercase tracking-widest">{{ now()->format('l, d F Y') }}</p>
        </div>
    </header>

    <!-- Table Container (Kartu Putih Melengkung) -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-stone-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-stone-50">
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em]">ID</th>
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em]">Pelanggan</th>
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em]">Rating</th>
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em]">Gambar</th>
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em]">Pesan</th>
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em]">Waktu</th>
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-stone-50/50 transition-colors group">
                        <td class="p-6 font-black text-[#2D2018]">#{{ $loop->iteration }}</td>
                        
                        <td class="p-6">
                            <p class="font-bold text-[#2D2018] capitalize">{{ $review->nama }}</p>
                            <p class="text-[9px] text-stone-400 font-bold uppercase tracking-widest">Customer</p>
                        </td>

                        <td class="p-6">
                            <div class="flex text-yellow-400 text-[10px]">
                                @for($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                        </td>

                        {{-- Kolom Gambar --}}
                        <td class="p-6">
                            @if($review->image)
                                <img src="{{ asset('storage/'.$review->image) }}" class="w-10 h-10 object-cover rounded-xl shadow-sm">
                            @else
                                <div class="w-10 h-10 bg-stone-50 rounded-xl flex items-center justify-center border border-dashed border-stone-200">
                                    <span class="text-[8px] text-stone-300 font-black uppercase italic">Empty</span>
                                </div>
                            @endif
                        </td>

                        {{-- Ganti bagian kolom Pesan dengan kode di bawah ini --}}
                        <td class="p-6">
                            <p class="text-stone-600 text-sm italic font-medium leading-relaxed">
                                {{-- Laravel akan mencoba menampilkan satu per satu mana yang tidak kosong --}}
                                "{{ $review->pesan ?? $review->komentar ?? $review->review ?? $review->ulasan }}"
                            </p>
                        </td>

                        {{-- Kolom Waktu --}}
                        <td class="p-6 whitespace-nowrap">
                            <p class="text-stone-500 text-[11px] font-bold">
                                {{ $review->created_at->diffForHumans() }}
                            </p>
                        </td>

                        {{-- Kolom Aksi --}}
                        <td class="p-6 text-center">
                            {{-- Pastikan route destroy sudah benar di web.php --}}
                            <form action="{{ route('admin.reviews', $review->id) }}" method="POST">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus ulasan ini?')" class="p-2.5 bg-red-50 text-red-500 rounded-2xl hover:bg-red-500 hover:text-white transition-all shadow-sm group">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-24 text-center">
                            <div class="flex flex-col items-center justify-center opacity-20">
                                <span class="text-4xl mb-4">☕</span>
                                <p class="italic text-stone-400 font-bold uppercase tracking-widest text-xs">Belum ada ulasan masuk.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection