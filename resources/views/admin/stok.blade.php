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

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-stone-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-stone-50">
                        {{-- Tambah Header No --}}
                        <th class="px-6 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em] w-16 text-center">No</th>
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em]">Produk</th>
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em]">Kategori</th>
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em]">Harga</th>
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em]">Jumlah Stok</th>
                        <th class="px-8 py-6 text-[10px] font-black text-stone-300 uppercase tracking-[0.2em] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                    <tr class="border-b border-stone-50 hover:bg-stone-50/50 transition-colors">
                        {{-- Tambah Baris Nomor Otomatis --}}
                        <td class="px-6 py-6 text-center text-stone-400 font-bold text-xs">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset($menu->foto) }}" 
                                     class="w-12 h-12 rounded-xl object-cover shadow-sm bg-stone-100"
                                     onerror="this.src='{{ asset('img/1.png') }}'">
                                <span class="font-black text-[#2D2018] uppercase tracking-tight">
                                    {{ $menu->nama_menu ?? 'NAMA TIDAK DITEMUKAN' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-stone-400 font-bold text-xs uppercase tracking-wider">
                            {{ $menu->kategori ?? '-' }}
                        </td>
                        <td class="px-8 py-6 font-black text-[#2D2018]">
                            Rp {{ number_format($menu->harga ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-6">
                            @php $stokValue = $menu->stok ?? 0; @endphp 
                            <div class="flex items-center gap-2">
                                <span class="font-black text-lg {{ $stokValue > 0 ? 'text-[#2D2018]' : 'text-red-500' }}">
                                    {{ $stokValue }}
                                </span>
                                <span class="text-[10px] font-black uppercase {{ $stokValue > 0 ? 'text-green-500' : 'text-red-400' }}">
                                    {{ $stokValue > 0 ? 'Tersedia' : 'Habis' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <button
                                onclick="openEditModal('{{ $menu->id }}', '{{ $menu->stok }}', '{{ $menu->nama_menu }}')"
                                class="text-caramel font-black hover:text-[#2D2018] transition-colors uppercase text-[10px] tracking-widest border border-caramel/20 px-4 py-2 rounded-lg hover:bg-caramel/5">
                                Edit Stok
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-12 text-center text-stone-400 font-bold uppercase text-xs tracking-[0.2em]">
                            Belum ada data menu
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- MODAL EDIT STOK (Sembunyi secara default) -->
<div id="editModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-white rounded-[2rem] p-8 w-full max-w-md shadow-2xl">
        <h3 class="text-2xl font-black text-[#2D2018] uppercase italic mb-1">Update Stok</h3>
        <p id="modalMenuName" class="text-stone-400 text-xs font-bold uppercase tracking-widest mb-6"></p>
        
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Jumlah Stok Baru</label>
                <input type="number" name="stok" id="inputStok" 
                       class="w-full bg-stone-50 border border-stone-100 rounded-xl px-4 py-4 font-black text-[#2D2018] focus:outline-none focus:border-caramel transition-all"
                       required min="0">
            </div>
            
            <div class="flex gap-3">
                {{-- Pastikan type="button" agar tidak memicu submit form --}}
                <button type="button" onclick="closeEditModal()" class="flex-1 py-4 bg-[#ff0000] text-white rounded-xl font-black uppercase text-xs tracking-widest hover:bg-caramel transition-all">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-4 bg-[#09bb02] text-white rounded-xl font-black uppercase text-xs tracking-widest hover:bg-caramel transition-all">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, currentStok, name) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    
    let url = "{{ route('admin.stok.update', ':id') }}";
    form.action = url.replace(':id', id);
    
    document.getElementById('inputStok').value = currentStok;
    document.getElementById('modalMenuName').innerText = name;
    modal.classList.remove('hidden');
}

// TAMBAHKAN FUNGSI INI
function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
}

// Opsional: Menutup modal jika area di luar kotak putih diklik
window.onclick = function(event) {
    const modal = document.getElementById('editModal');
    if (event.target == modal) {
        closeEditModal();
    }
}
</script>
@endsection