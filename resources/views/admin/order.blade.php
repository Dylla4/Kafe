@extends('layouts.admin') {{-- Pastikan Anda menggunakan layout admin Anda --}}

@section('content')
<main class="flex-1 p-8 lg:p-12 overflow-x-hidden w-full relative">
    {{-- Header --}}
    <header class="flex justify-between items-end mb-10 w-full">
        <div>
            <h2 class="text-5xl font-black text-[#2D2018] tracking-tighter uppercase italic leading-none">Data Pesanan</h2>
            <p class="text-stone-400 text-base font-medium mt-2">Kelola semua pesanan pelanggan di sini.</p>
        </div>
        <div class="text-right">
            <p class="text-xs font-black text-stone-400 uppercase tracking-widest">{{ now()->format('l, d F Y') }}</p>
        </div>
    </header>

    {{-- Tabel Pesanan --}}
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
                        <th class="p-6 text-xs font-black text-stone-400 uppercase tracking-widest text-center">Kelola</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse($orders as $order)
                    <tr class="hover:bg-stone-50/50 transition-colors group">
                        {{-- ID --}}
                        <td class="p-6 font-black text-[#2D2018]">#{{ $order->id }}</td>
                        
                        {{-- Pelanggan --}}
                        <td class="p-6">
                            <p class="font-bold text-[#2D2018]">{{ $order->nama_pemesan }}</p>
                            <p class="text-[10px] text-stone-400 font-bold uppercase tracking-tighter">Customer</p>
                        </td>

                        {{-- Total Bayar --}}
                        <td class="p-6">
                            <p class="font-black text-orange-500 italic text-sm">Rp{{ number_format($order->total_bayar, 0, ',', '.') }}</p>
                        </td>

                        {{-- Waktu --}}
                        <td class="p-6 text-stone-500 text-xs font-bold">
                            {{ $order->created_at->format('H:i') }} <span class="text-[10px] opacity-50 ml-1">• {{ $order->created_at->format('d M') }}</span>
                        </td>

                        {{-- Status --}}
                        <td class="p-6 text-center">
                            <span class="px-4 py-1 rounded-full text-[9px] font-black uppercase tracking-widest
                                {{ $order->status == 'sukses' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }}">
                                {{ $order->status }}
                            </span>
                        </td>

                        {{-- Aksi Dropdown --}}
                        <td class="p-6 text-center">
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="text-[9px] font-black border-none bg-stone-100 rounded-lg p-2 focus:ring-2 focus:ring-orange-400 uppercase tracking-tighter cursor-pointer">
                                    <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>PROSES</option>
                                    <option value="siap" {{ $order->status == 'siap' ? 'selected' : '' }}>SIAP</option>
                                    <option value="sukses" {{ $order->status == 'sukses' ? 'selected' : '' }}>SELESAI</option>
                                </select>
                            </form>
                        </td>

                        {{-- Tombol Kelola --}}
                        <td class="p-6 text-center">
                            <button onclick="openOrderModal('{{ $order->id }}')" 
                                    class="bg-[#2D2018] text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#C19A6B] transition-all shadow-sm">
                                Kelola
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-20 text-center italic text-stone-400 font-bold uppercase tracking-widest text-xs opacity-50">
                            Belum ada data pesanan yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders instanceof \Illuminate\Pagination\LengthAwarePaginator && $orders->hasPages())
        <div class="p-6 bg-stone-50 border-t border-stone-100">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</main>

{{-- Layer Modal Konfirmasi --}}
@foreach($orders as $order)
<div id="confirm-modal-{{ $order->id }}" class="fixed inset-0 z-[100] hidden items-center justify-center bg-[#2D2018]/40 backdrop-blur-sm px-4">
    <div class="bg-white p-10 rounded-[3.5rem] shadow-2xl w-full max-w-sm text-center border border-stone-100 animate-in zoom-in duration-300">
        <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">☕</div>
        <h3 class="text-2xl font-black text-[#2D2018] uppercase italic leading-tight mb-1">Konfirmasi Pesanan</h3>
        <p class="text-stone-400 text-[11px] font-bold uppercase tracking-widest mb-10">Order ID #{{ $order->id }}</p>
        
        <div class="space-y-4">
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="sukses">
                <button type="submit" class="w-full py-5 bg-[#C19A6B] text-white rounded-3xl font-black text-xs uppercase tracking-[0.2em] shadow-xl hover:brightness-110 transition-all">
                    Konfirmasi Selesai
                </button>
            </form>

            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')" 
                        class="w-full py-5 bg-red-50 text-red-600 rounded-3xl font-black text-xs uppercase tracking-[0.2em] hover:bg-red-100 transition-colors">
                    Batalkan Pesanan
                </button>
            </form>

            <button type="button" onclick="closeOrderModal('{{ $order->id }}')" class="pt-4 text-stone-400 font-black text-[10px] uppercase tracking-[0.3em] hover:text-[#2D2018] block mx-auto">
                Kembali
            </button>
        </div>
    </div>
</div>
@endforeach

<script>
    function openOrderModal(id) {
        const modal = document.getElementById('confirm-modal-' + id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeOrderModal(id) {
        const modal = document.getElementById('confirm-modal-' + id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection