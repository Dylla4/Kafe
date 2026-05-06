@extends('layouts.admin') {{-- Pastikan Anda menggunakan layout admin Anda --}}

@section('content')
<main class="flex-1 p-8 lg:p-12 overflow-x-hidden w-full">
    
    <header class="flex justify-between items-end mb-10 w-full">
        <div>
            <h2 class="text-5xl font-black text-[#2D2018] tracking-tighter uppercase italic leading-none">Data Pesanan</h2>
            <p class="text-stone-400 text-base font-medium mt-2">Kelola semua pesanan pelanggan di sini.</p>
        </div>
        <div class="text-right">
            <p class="text-xs font-black text-stone-400 uppercase tracking-widest">{{ now()->format('l, d F Y') }}</p>
        </div>
    </header>

    <!-- Tabel Pesanan -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-stone-100 overflow-hidden w-full">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-stone-50 border-b border-stone-100">
                        <th class="p-6 text-xs font-black text-stone-400 uppercase tracking-widest">ID</th>
                        <th class="p-6 text-xs font-black text-stone-400 uppercase tracking-widest">Pelanggan</th>
                        <th class="p-6 text-xs font-black text-stone-400 uppercase tracking-widest">Total Bayar</th>
                        <th class="p-6 text-xs font-black text-stone-400 uppercase tracking-widest">Waktu</th>
                        <th class="p-6 text-xs font-black text-stone-400 uppercase tracking-widest">Status</th>
                        <th class="p-6 text-xs font-black text-stone-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse($orders as $order)
                    <tr class="hover:bg-stone-50/50 transition-colors">
                        <td class="p-6 font-black text-[#2D2018]">#{{ $order->id }}</td>
                        <td class="p-6">
                            <p class="font-bold text-[#2D2018]">{{ $order->nama_pemesan }}</p>
                            <p class="text-[10px] text-stone-400 font-bold uppercase tracking-tighter">Customer</p>
                        </td>
                        <td class="p-6">
                            <p class="font-black text-orange-500 italic">Rp{{ number_format($order->total_bayar, 0, ',', '.') }}</p>
                        </td>
                        <td class="p-6 text-stone-500 text-sm font-medium">
                            {{ $order->created_at->format('H:i') }} <span class="text-[10px] opacity-50">• {{ $order->created_at->format('d M') }}</span>
                        </td>
                        <td class="p-6">
                            <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                {{ $order->status == 'sukses' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="p-6 text-center">
                            <div class="flex justify-center gap-2">
                                {{-- Form Update Status --}}
                                <form action="{{ route('admin.orders', $order->id) }}" method="POST" class="inline-block">
                                    @csrf @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-[10px] font-bold border-none bg-stone-100 rounded-lg p-2 focus:ring-2 focus:ring-orange-400">
                                        <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>PROSES</option>
                                        <option value="siap" {{ $order->status == 'siap' ? 'selected' : '' }}>SIAP</option>
                                        <option value="sukses" {{ $order->status == 'sukses' ? 'selected' : '' }}>SELESAI</option>
                                    </select>
                                </form>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.orders', $order->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus pesanan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition">
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
                        <td colspan="6" class="p-20 text-center italic text-stone-400">
                            Belum ada data pesanan yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination jika ada --}}
        @if($orders->hasPages())
        <div class="p-6 bg-stone-50 border-t border-stone-100">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</main>
@endsection