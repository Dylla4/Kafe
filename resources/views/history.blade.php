<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .order-card:hover { transform: translateY(-4px); }
    </style>
</head>
<body class="bg-stone-50 text-stone-800 p-6 md:p-12">

<div class="max-w-4xl mx-auto">
    {{-- Header Section --}}
    <div class="flex items-center justify-between mb-10 pb-6 border-b border-stone-200">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-[#3C2A21] flex items-center justify-center shadow-lg shadow-stone-200 text-white text-2xl">
                📜
            </div>
            <div>
                <h1 class="text-3xl font-black text-[#3C2A21] tracking-tighter uppercase">Riwayat Pesanan</h1>
                <p class="text-stone-500 text-sm font-medium">Lacak dan ulas pesanan Valeria Coffee Anda</p>
            </div>
        </div>
        <a href="{{ url('/') }}" class="hidden md:flex items-center gap-2 text-xs font-black uppercase tracking-widest text-stone-400 hover:text-orange-700 transition-colors">
            🏠 Home
        </a>
    </div>

    <div class="space-y-6">
        @forelse($orders as $order)
            <div class="order-card bg-white p-6 rounded-[2.5rem] shadow-sm border border-stone-100 flex flex-col md:flex-row justify-between items-center gap-6 transition-all duration-300">
                
                {{-- Info Pesanan --}}
                <div class="flex-1 w-full md:w-auto">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-[10px] font-black uppercase tracking-widest text-white bg-[#A06040] px-3 py-1 rounded-lg">
                            #VAL-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                        
                        {{-- Status Badge --}}
                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider 
                            {{ $order->status == 'Selesai' ? 'bg-green-100 text-green-700' : ($order->status == 'Dibatalkan' ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700') }}">
                            ● {{ $order->status }}
                        </span>
                    </div>

                    <h3 class="font-bold text-xl text-[#3C2A21]">{{ $order->nama_pemesan }}</h3>
                    
                    <div class="flex flex-wrap items-center gap-3 text-[11px] text-stone-400 mt-2 font-bold uppercase tracking-wider">
                        <div class="flex items-center gap-1">
                            📅 {{ $order->created_at->format('d M Y') }}
                        </div>
                        <span class="text-stone-200">|</span>
                        <div class="flex items-center gap-1 text-orange-700">
                            🥡 {{ str_replace('_', ' ', strtoupper($order->jenis_pesanan)) }}
                        </div>
                        <span class="text-stone-200">|</span>
                        <div class="flex items-center gap-1">
                            💳 {{ strtoupper($order->metode_pembayaran) }}
                        </div>
                    </div>
                </div>

                {{-- Aksi & Harga (HANYA SATU BLOK DI SINI) --}}
                <div class="w-full md:w-auto flex md:flex-col justify-between items-center md:items-end gap-4 border-t md:border-t-0 pt-4 md:pt-0">
                    <div class="text-left md:text-right">
                        <p class="text-[10px] text-stone-400 font-black uppercase tracking-widest">Total Bayar</p>
                        <p class="text-2xl font-black text-[#3C2A21]">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</p>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        {{-- Tombol Ulasan: Hanya jika Selesai --}}
                        {{-- Tombol Ulasan: Gunakan strtolower agar lebih aman saat pengecekan --}}
@if(strtolower($order->status) == 'sukses' || strtolower($order->status) == 'selesai')
    @if(!$order->review)
        {{-- Ganti $o->id menjadi $order->id sesuai dengan @forelse kamu --}}
        <a href="{{ route('ulasan.create', ['order_id' => $order->id]) }}" 
           class="px-5 py-2.5 bg-orange-700 text-white rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-orange-800 transition-all shadow-md active:scale-95">
           ⭐ Ulasan
        </a>
    @else
        <div class="px-4 py-2 bg-green-50 text-green-700 rounded-2xl border border-green-100">
            <span class="text-[10px] font-black uppercase tracking-widest">Diulas ✅</span>
        </div>
    @endif
@endif

                        {{-- Tombol Cetak --}}
                        <a href="{{ route('invoice.print', $order->id) }}" class="p-2.5 bg-stone-100 text-stone-600 rounded-2xl hover:bg-stone-900 hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            {{-- Empty State --}}
            <div class="text-center py-24 bg-white rounded-[3rem] border-2 border-dashed border-stone-200 shadow-inner">
                <div class="text-7xl mb-6 opacity-20">☕</div>
                <h3 class="text-2xl font-black text-stone-800 uppercase tracking-widest">Keranjang Kenangan Masih Kosong</h3>
                <p class="text-stone-400 mt-2 mb-10 text-sm max-w-xs mx-auto">Anda belum pernah memesan. Mari buat momen pertama Anda di Valeria Coffee.</p>
                <a href="{{ url('/') }}" class="bg-[#3C2A21] text-white px-12 py-5 rounded-full font-black uppercase tracking-widest hover:bg-black transition shadow-2xl shadow-stone-300 inline-block active:scale-95">
                    Pesan Kopi Sekarang
                </a>
            </div>
        @endforelse
    </div>

    {{-- Footer --}}
    <div class="mt-16 text-center">
        <p class="text-[10px] text-stone-400 font-bold uppercase tracking-[0.3em]">&copy; 2026 VALERIA COFFEE POS SYSTEM v1.0</p>
    </div>
</div>

</body>
</html>