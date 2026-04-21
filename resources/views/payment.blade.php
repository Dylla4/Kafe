<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Refresh otomatis jika status masih pending/diproses untuk cek update admin --}}
    @if(in_array(strtolower($order->status), ['pending', 'waiting', 'diproses']))
        <meta http-equiv="refresh" content="15">
    @endif

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .animate-fade-in { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-stone-50 text-stone-800 p-6 flex items-center justify-center min-h-screen">

<div class="max-w-md w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-stone-100 animate-fade-in">
    {{-- Header --}}
    <div class="bg-stone-900 p-8 text-center text-white">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-orange-700 rounded-xl mb-3">
            <span class="text-2xl">☕</span>
        </div>
        <h1 class="text-xl font-black uppercase tracking-[0.2em]">Valeria Coffee</h1>
        <p class="text-stone-400 text-[10px] mt-1 uppercase tracking-widest">Selesaikan Pembayaran Anda</p>
    </div>

    <div class="p-8">
        {{-- Info Total & ID --}}
        <div class="flex justify-between items-end mb-8 pb-6 border-b border-stone-100">
            <div>
                <p class="text-[10px] text-stone-400 uppercase font-black tracking-widest mb-1">Total Tagihan</p>
                {{-- Menggunakan total_bayar agar sinkron dengan Controller --}}
                <p class="text-3xl font-black text-orange-700">Rp {{ number_format($order->total_bayar ?? $order->total_harga, 0, ',', '.') }}</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] text-stone-400 uppercase font-black tracking-widest mb-1">ID Pesanan</p>
                <p class="font-bold text-stone-800">#{{ $order->id }}</p>
            </div>
        </div>

        @php
            $method = strtolower(trim($order->metode_pembayaran ?? ''));
            // PERBAIKAN: 'diproses' dihapus agar QRIS tetap muncul sebelum benar-benar 'sukses'
            $isSuccess = in_array(strtolower($order->status), ['sukses', 'selesai', 'lunas']);
        @endphp

        <div class="min-h-62.5 flex flex-col justify-center">
            @if($isSuccess)
                {{-- Tampilan jika sudah sukses --}}
                <div class="text-center space-y-4">
                    <div class="bg-green-50 p-8 rounded-4xl border-2 border-dashed border-green-100">
                        <div class="text-5xl mb-4">✅</div>
                        <p class="text-sm font-black text-green-700 uppercase tracking-widest">Pembayaran Berhasil</p>
                        <p class="text-[10px] text-green-600/70 mt-1">Pesanan Anda sedang kami siapkan.</p>
                    </div>
                </div>
            @elseif($method == 'qris')
                {{-- Tampilan QRIS --}}
                <div class="text-center">
                    <p class="text-[10px] font-black text-stone-400 mb-4 uppercase tracking-[0.2em]">Scan QRIS Resmi Kami</p>
                    <div class="relative group inline-block">
                        <div class="absolute -inset-1 bg-gradient-to-r from-orange-600 to-stone-400 rounded-3xl blur opacity-20 transition duration-1000"></div>
                        <div class="relative bg-white p-3 rounded-3xl border-2 border-dashed border-stone-200">
                            {{-- Pastikan file ini ada di public/img/qris-bank.jpeg --}}
                            <img src="{{ asset('img/qris-bank.jpeg') }}" alt="QRIS" class="w-56 h-auto mx-auto rounded-xl">
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-center gap-2 opacity-50">
                        <span class="px-2 py-1 bg-stone-100 text-[8px] font-bold rounded">GOPAY</span>
                        <span class="px-2 py-1 bg-stone-100 text-[8px] font-bold rounded">OVO</span>
                        <span class="px-2 py-1 bg-stone-100 text-[8px] font-bold rounded">DANA</span>
                    </div>
                </div>
            @else
                {{-- Tampilan Tunai --}}
                <div class="text-center space-y-4">
                    <div class="bg-orange-50/50 p-8 rounded-4xl border-2 border-dashed border-orange-100">
                        <p class="text-[10px] font-black text-orange-900/40 uppercase tracking-widest mb-3">Pembayaran Tunai</p>
                        <div class="text-5xl mb-4">💵</div>
                        <p class="text-xs text-stone-600 font-medium leading-relaxed">
                            Silakan lakukan pembayaran langsung di kasir senilai:<br>
                            <span class="text-xl font-black text-stone-800">Rp {{ number_format($order->total_bayar ?? $order->total_harga, 0, ',', '.') }}</span>
                        </p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Bagian Tombol Aksi --}}
        <div class="mt-10 space-y-3">
            @if($isSuccess)
                <a href="{{ route('order.receipt', $order->id) }}" class="block text-center w-full bg-stone-900 text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-orange-700 transition shadow-xl">
                    Lihat Rincian Pesanan
                </a>
            @else
                <form action="{{ route('order.konfirmasi', $order->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pembayaran? Pesanan akan segera diproses.')">
                    @csrf
                    <button type="submit" class="bg-[#3C2A21] hover:bg-orange-800 text-white w-full py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all active:scale-[0.98] shadow-lg">
                        Konfirmasi Pembayaran
                    </button>
                </form>
            @endif

            <a href="{{ route('order.history') }}" class="block text-center w-full bg-stone-100 text-stone-500 py-4 rounded-2xl font-bold text-[10px] uppercase tracking-widest hover:bg-stone-200 transition">
                Cek Riwayat Pesanan
            </a>
        </div>
    </div>
</div>

</body>
</html>