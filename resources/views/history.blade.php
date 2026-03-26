<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-stone-50 text-stone-800 p-6 md:p-12">

<div class="max-w-4xl mx-auto">
    {{-- Header: Tombol navigasi di kanan atas sudah dihapus untuk fokus visual --}}
    <div class="flex items-center mb-10 pb-6 border-b border-stone-200">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-[#A06040] flex items-center justify-center shadow-lg shadow-orange-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-black text-[#3C2A21] tracking-tighter">Riwayat Pesanan</h1>
                <p class="text-stone-500 font-medium">Daftar transaksi Anda di Valeria Coffee</p>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        @forelse($orders as $order)
            @php
                $metode = strtolower($order->metode_pembayaran);
                $status = strtolower($order->status);
                $isConfirmed = ($metode == 'cash' || $metode == 'qris' || $status == 'sukses' || $status == 'dikonfirmasi');
            @endphp

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-stone-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 hover:shadow-md transition-all border-l-8 {{ $isConfirmed ? 'border-l-green-400' : 'border-l-orange-400' }}">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-[10px] font-black uppercase tracking-widest text-[#A06040] bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                            #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                        
                        @if($isConfirmed)
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-green-50 text-green-700 border border-green-100 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> Dikonfirmasi
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-orange-50 text-orange-700 border border-orange-100 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-bounce"></span> Menunggu
                            </span>
                        @endif
                    </div>

                    <h3 class="font-extrabold text-2xl text-[#3C2A21] tracking-tight">{{ $order->nama_pembeli }}</h3>
                    
                    <div class="flex flex-wrap items-center gap-4 text-sm text-stone-500 mt-2 font-medium">
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </div>
                        <div class="hidden md:block w-1 h-1 bg-stone-300 rounded-full"></div>
                        <div class="flex items-center gap-1.5 uppercase font-bold text-[10px] tracking-wider text-stone-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            {{ $order->metode_pembayaran }}
                        </div>
                    </div>
                </div>

                <div class="text-right w-full md:w-auto border-t md:border-t-0 pt-5 md:pt-0 flex md:flex-col justify-between items-center md:items-end">
                    <div>
                        <p class="text-[10px] text-stone-400 font-black uppercase tracking-widest md:mb-1">Total Bayar</p>
                        <p class="text-2xl font-black text-[#3C2A21] tracking-tighter">Rp {{ number_format($order->total_harga) }}</p>
                    </div>
                    
                    <a href="{{ route('invoice.print', $order->id) }}" class="inline-flex items-center gap-2 text-sm font-bold bg-white border-2 border-stone-100 text-stone-700 px-5 py-2.5 rounded-2xl hover:bg-[#3C2A21] hover:text-white hover:border-[#3C2A21] transition-all group shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4" />
                        </svg>
                        Lihat Struk
                    </a>
                </div>
            </div>
        @empty
            {{-- State Kosong: Menggunakan rounded-4xl sesuai saran IntelliSense --}}
            <div class="text-center py-20 bg-white rounded-4xl border-2 border-dashed border-stone-200 shadow-sm">
                <div class="text-6xl mb-4 opacity-20">☕</div>
                <h3 class="text-xl font-bold text-stone-600">Belum Ada Pesanan</h3>
                <p class="text-stone-400 mt-2 mb-8 text-sm">Mari mulai pesanan pertama Anda hari ini.</p>
                
                <a href="{{ url('/') }}" class="bg-[#A06040] text-white px-10 py-4 rounded-full font-black hover:bg-[#8d5438] transition shadow-lg shadow-orange-100 inline-block">
                    Pesan Sekarang
                </a>
            </div>
        @endforelse
    </div>

    {{-- Navigasi Utama di bagian bawah --}}
    @if($orders->isNotEmpty())
    <div class="mt-12 flex justify-center">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-3 bg-[#3C2A21] text-white px-10 py-4 rounded-full font-bold hover:bg-black transition shadow-xl group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Kembali ke Home
        </a>
    </div>
    @endif
    
    <div class="mt-16 text-center text-[10px] text-stone-400 font-bold uppercase tracking-[0.2em]">
        <p>&copy; 2026 Valeria Coffee POS System v1.0</p>
    </div>
</div>

</body>
</html>