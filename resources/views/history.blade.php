<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 text-stone-800 font-sans p-6 md:p-12">

<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-10 pb-4 border-b border-stone-200">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-orange-100 flex items-center justify-center border-2 border-orange-200 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-orange-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-black text-stone-900 tracking-tighter">Riwayat Pesanan</h1>
                <p class="text-stone-500 mt-1">Daftar transaksi Anda di Valeria Coffee</p>
            </div>
        </div>
        <a href="{{ url('/') }}" class="bg-stone-100 text-stone-600 px-6 py-2.5 rounded-full font-bold hover:bg-stone-200 transition text-sm">Kembali ke Menu</a>
    </div>

    <div class="space-y-6">
        @forelse($orders as $order)
            <div class="bg-white p-7 rounded-3xl shadow-sm border border-stone-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 hover:shadow-md transition-shadow">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-xs font-bold uppercase tracking-widest text-orange-700 bg-orange-50 px-3 py-1 rounded-full border border-orange-100">#{{ $order->id }}</span>
                        
                        @if($order->status == 'sukses')
                            <span class="px-3 py-1 rounded-full text-[11px] font-black uppercase bg-green-50 text-green-700 border border-green-100">Dikonfirmasi ✅</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-[11px] font-black uppercase bg-orange-50 text-orange-700 border border-orange-100 animate-pulse">Menunggu... ⏳</span>
                        @endif
                    </div>

                    <h3 class="font-extrabold text-2xl text-stone-900 tracking-tight">{{ $order->nama_pembeli }}</h3>
                    
                    <div class="flex items-center gap-4 text-sm text-stone-500 mt-2 font-medium">
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </div>
                        <div class="w-1.5 h-1.5 bg-stone-300 rounded-full"></div>
                        <div class="flex items-center gap-1.5 uppercase font-bold text-xs tracking-wider">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            {{ $order->metode_pembayaran }}
                        </div>
                    </div>
                </div>

                <div class="text-right w-full md:w-auto border-t md:border-t-0 pt-5 md:pt-0">
                    <p class="text-xs text-stone-400 font-bold uppercase tracking-widest">Total Harga</p>
                    <p class="text-3xl font-black text-orange-700 tracking-tighter">Rp {{ number_format($order->total_harga) }}</p>
                    <a href="{{ route('invoice.print', $order->id) }}" class="inline-flex items-center gap-2 mt-4 text-sm font-bold bg-white border-2 border-orange-200 text-orange-700 px-5 py-2 rounded-xl hover:bg-orange-700 hover:text-white transition group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4" />
                        </svg>
                        Lihat Struk
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-24 bg-white rounded-3xl border-2 border-dashed border-stone-200">
                <p class="text-8xl mb-6">☕</p>
                <h3 class="text-2xl font-bold text-stone-600">Belum Ada Pesanan</h3>
                <p class="text-stone-400 mt-2 mb-8">Anda belum memiliki riwayat transaksi di kafe kami.</p>
                <a href="{{ url('/') }}" class="bg-orange-700 text-white px-8 py-3 rounded-full font-black hover:bg-orange-800 transition shadow-lg shadow-orange-200">
                    Pesan Menu Sekarang
                </a>
            </div>
        @endforelse
    </div>
    
    <div class="mt-16 text-center text-sm text-stone-400">
        <p>&copy; 2024 Valeria Coffee. Terima kasih telah menjadi pelanggan setia kami.</p>
    </div>
</div>

</body>
</html>