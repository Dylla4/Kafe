<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Refresh otomatis setiap 5 detik jika status belum sukses --}}
    @if($order->status != 'sukses')
        <meta http-equiv="refresh" content="5">
    @endif
</head>
<body class="bg-stone-50 text-stone-800 font-sans p-6 flex items-center justify-center min-h-screen">

<div class="max-w-md w-full bg-white rounded-3xl shadow-2xl overflow-hidden border border-stone-100">
    {{-- Header Pembayaran --}}
    <div class="bg-orange-700 p-8 text-center text-white">
        <h1 class="text-2xl font-bold uppercase tracking-widest">Pembayaran</h1>
        <p class="text-orange-200 text-sm mt-1">Selesaikan pesanan Anda</p>
    </div>

    <div class="p-8">
        {{-- Info Total & ID --}}
        <div class="flex justify-between items-center mb-8 pb-6 border-b border-stone-100">
            <div class="text-left">
                <p class="text-xs text-stone-400 uppercase font-bold tracking-tighter">Total Bayar</p>
                <p class="text-2xl font-black text-orange-700">Rp {{ number_format($order->total_harga) }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-stone-400 uppercase font-bold tracking-tighter">ID Pesanan</p>
                <p class="font-bold text-stone-800">#{{ $order->id }}</p>
            </div>
        </div>

        @php
            $method = strtolower(trim($order->metode_pembayaran ?? ''));
            $isSuccess = trim(strtolower($order->status)) == 'sukses';
        @endphp

        {{-- Konten QRIS / Tunai --}}
        <div class="min-h-[220px] flex flex-col justify-center">
            @if($method == 'qris')
                <div class="text-center">
                    <p class="text-sm font-bold text-stone-600 mb-4 uppercase tracking-widest">Scan QRIS Di Bawah Ini</p>
                    <div class="bg-white p-4 rounded-3xl border-2 border-orange-100 inline-block shadow-sm">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=VALERIA-{{ $order->id }}" class="w-52 h-52 mx-auto">
                    </div>
                </div>
            @elseif($method == 'cash' || $method == 'tunai')
                <div class="text-center space-y-4">
                    <div class="bg-stone-50 p-6 rounded-3xl border-2 border-dashed border-stone-200">
                        <p class="text-sm font-bold text-stone-600 uppercase tracking-widest mb-2">Pembayaran Tunai</p>
                        <div class="text-5xl mb-3">💵</div>
                        <p class="text-xs text-stone-500">Silakan bayar di kasir: <br>
                        <span class="text-xl font-black text-stone-800">Rp {{ number_format($order->total_harga) }}</span></p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Bagian Tombol Aksi --}}
        <div class="mt-10 space-y-4">
            @if($isSuccess)
                <div class="flex items-center justify-center gap-3 text-green-600 font-bold bg-green-50 py-4 rounded-2xl border border-green-200">
                    DIKONFIRMASI ✅
                </div>
                <a href="{{ route('invoice.print', $order->id) }}" class="block text-center w-full bg-green-600 text-white py-4 rounded-2xl font-black hover:bg-green-700 transition shadow-lg">
                    LIHAT STRUK
                </a>
            @else
                {{-- Tombol Konfirmasi Berwarna Hijau --}}
                <form action="{{ route('payment.confirm', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-3 bg-green-600 text-white font-black py-4 rounded-2xl hover:bg-green-700 transition shadow-lg shadow-green-100">
                        Konfirmasi
                    </button>
                </form>

                {{-- Tombol Riwayat Tetap Hitam --}}
                <a href="{{ url('/history') }}" class="block text-center w-full bg-stone-900 text-white py-4 rounded-2xl font-bold uppercase tracking-wider hover:bg-stone-800 transition shadow-md">
                    Cek Status Riwayat
                </a>
            @endif
        </div>
    </div>
</div>

</body>
</html>