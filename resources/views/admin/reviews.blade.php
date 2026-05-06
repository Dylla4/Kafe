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
                    @forelse($reviews ?? [] as $review)
                    <tr class="group hover:bg-stone-50/50 transition-colors">
                        <!-- ID -->
                        <td class="px-8 py-6 font-black text-[#2D2018]">#{{ $review->id }}</td>
                        
                        <!-- Pelanggan -->
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="font-bold text-[#2D2018]">{{ $review->nama ?? 'Sha' }}</span>
                                <span class="text-[9px] font-black text-stone-300 uppercase tracking-widest">Customer</span>
                            </div>
                        </td>

                        <!-- Rating (Bintang bergaya minimalis) -->
                        <td class="px-8 py-6">
                            <div class="flex gap-0.5 text-caramel">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-sm">{{ $i <= ($review->rating ?? 5) ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                        </td>

                        <!-- Pesan -->
                        <td class="px-8 py-6">
                            <p class="text-stone-500 italic text-sm line-clamp-1 max-w-xs">
                                "{{ $review->pesan ?? 'Kopi susunya enak banget...' }}"
                            </p>
                        </td>

                        <!-- Waktu -->
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-1.5 text-stone-400">
                                <span class="font-bold text-[#2D2018] text-sm">{{ $review->created_at->format('H:i') }}</span>
                                <span class="text-[10px] font-medium opacity-60">• {{ $review->created_at->format('d M') }}</span>
                            </div>
                        </td>

                        <!-- Aksi -->
                        <td class="px-8 py-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-400 rounded-xl hover:bg-red-500 hover:text-white transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center opacity-20">
                                <span class="text-4xl mb-2">💬</span>
                                <p class="font-bold italic">Belum ada ulasan yang masuk...</p>
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