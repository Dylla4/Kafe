@extends('layouts.admin')

@section('content')
<main class="p-8 lg:p-12 w-full bg-[#FDFCFB] min-h-screen">
    <!-- Header -->
    <header class="flex justify-between items-end mb-10 w-full">
        <div>
            <p class="text-xs font-black text-stone-400 uppercase tracking-[0.3em] mb-2">Inventory Management</p>
            <h2 class="text-5xl font-black text-[#2D2018] tracking-tighter uppercase italic leading-none">
                Stok <span class="text-caramel">Menu</span>
            </h2>
        </div>
        <div class="text-right">
            <p class="text-xs font-black text-stone-400 uppercase tracking-widest">{{ now()->format('l, d F Y') }}</p>
        </div>
    </header>

    <!-- Table Container -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-stone-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-stone-50">
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em]">Produk</th>
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em]">Kategori</th>
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em]">Harga</th>
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em]">Status Stok</th>
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse($menus ?? [] as $menu)
                    <tr class="group hover:bg-stone-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-stone-100 rounded-2xl flex items-center justify-center text-xl">☕</div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-[#2D2018]">{{ $menu->nama }}</span>
                                    <span class="text-[9px] font-black text-stone-300 uppercase tracking-widest">ID: #{{ $menu->id }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-stone-100 text-[#2D2018] text-[10px] font-black uppercase rounded-full">
                                {{ $menu->kategori }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="font-bold text-caramel italic">Rp{{ number_with_delimiter($menu->harga) }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <form action="{{ route('admin.stok.update', $menu->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-xl transition-all {{ $menu->is_available ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                    <div class="w-2 h-2 rounded-full animate-pulse {{ $menu->is_available ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                    <span class="text-[11px] font-black uppercase tracking-tighter">
                                        {{ $menu->is_available ? 'Tersedia' : 'Habis' }}
                                    </span>
                                </button>
                            </form>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="#" class="w-8 h-8 flex items-center justify-center bg-stone-100 text-stone-400 rounded-xl hover:bg-[#2D2018] hover:text-white transition-all">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center text-stone-400 font-bold italic">Belum ada data menu...</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection