<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Meta refresh setiap 5 detik untuk cek status otomatis (Opsional) --}}
    @if($order->status == 'menunggu_pembayaran')
        <meta http-equiv="refresh" content="5">
    @endif
</head>
<body class="bg-stone-50 text-stone-800 font-sans p-6 flex items-center justify-center min-h-screen">

<div class="max-w-md w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-stone-100">
    <div class="bg-orange-700 p-8 text-center text-white">
        <h1 class="text-2xl font-bold uppercase tracking-widest">Pembayaran</h1>
        <p class="text-orange-200 text-sm mt-1">Selesaikan pesanan Anda</p>
    </div>

    <div class="p-8">
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
            // Perbaikan krusial: Gunakan trim() dan strtolower()
            $method = strtolower(trim($order->metode_pembayaran ?? ''));
        @endphp

        {{-- Logika Pengalihan Tampilan Dinamis --}}
        @if($method == 'qris')
            <div class="text-center">
                <p class="text-sm font-bold text-stone-600 mb-4 uppercase tracking-widest text-center">Scan QRIS Di Bawah Ini</p>
                <div class="bg-white p-4 rounded-3xl border-2 border-orange-100 inline-block shadow-sm">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=VALERIA-COFFEE-{{ $order->id }}-TOTAL-{{ $order->total_harga }}" 
                         alt="QRIS Valeria Coffee" class="w-56 h-56 mx-auto">
                </div>
                <p class="text-[10px] text-stone-400 mt-4 italic leading-relaxed uppercase font-bold">Dana • OVO • GoPay • ShopeePay • M-Banking</p>
            </div>

        @elseif($method == 'transfer')
            <div class="space-y-6">
                <p class="text-sm font-bold text-stone-600 text-center uppercase tracking-widest">Instruksi Transfer</p>
                <div class="bg-orange-50 p-6 rounded-3xl border border-orange-100 relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-xs font-bold text-orange-400 uppercase mb-2">Nomor Rekening BCA</p>
                        <p class="text-2xl font-black text-stone-800 tracking-wider">1234 5678 90</p>
                        <p class="text-sm text-stone-600 mt-1 uppercase font-semibold">a.n. Valeria Coffee Group</p>
                    </div>
                    <div class="absolute -right-4 -bottom-4 opacity-10 text-6xl font-black italic">BCA</div>
                </div>
                <div class="text-center p-4 bg-stone-50 rounded-2xl border border-dashed border-stone-200">
                    <p class="text-xs text-stone-500 font-medium tracking-tight">Mohon sertakan ID #{{ $order->id }} di berita transfer.</p>
                </div>
            </div>

        {{-- Handling jika data kosong atau tidak valid --}}
        @else
            <div class="text-center p-6 bg-red-50 rounded-3xl border-2 border-dashed border-red-200">
                <p class="text-sm text-red-600 font-bold uppercase tracking-tight">⚠️ Metode Tidak Terdeteksi</p>
                <p class="text-[11px] text-red-400 mt-2 font-medium">Data pembayaran kosong. Silakan kembali ke keranjang dan pilih metode pembayaran (QRIS/Transfer).</p>
                <a href="{{ route('cart.show') }}" class="inline-block mt-4 text-xs font-bold text-white bg-red-600 px-4 py-2 rounded-xl">Kembali Pilih Metode</a>
            </div>
        @endif

        <div class="mt-10 space-y-4">
            @if($order->status == 'sukses')
                {{-- Tombol jika sudah dikonfirmasi Admin --}}
                <a href="{{ route('invoice.print', $order->id) }}" class="block text-center w-full bg-green-600 text-white py-4 rounded-2xl font-black text-lg animate-bounce">
                    PEMBAYARAN SUKSES! LIHAT STRUK 🎉
                </a>
            @else
                <div class="flex items-center justify-center gap-3 text-orange-600 font-bold bg-orange-50 py-3 rounded-2xl animate-pulse">
                    <span class="w-2 h-2 bg-orange-600 rounded-full"></span>
                    Menunggu Konfirmasi Kasir...
                </div>

                {{-- Form Simulasi Konfirmasi (Untuk Keperluan Pengembangan) --}}
                <form action="{{ route('order.pay', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-stone-900 hover:bg-orange-800 text-white py-4 rounded-2xl font-bold text-lg transition-all shadow-xl active:scale-95 uppercase tracking-widest">
                        Saya Sudah Bayar ✅
                    </button>
                </form>
            @endif
            
            <a href="{{ route('home') }}" class="block text-center text-sm text-stone-400 hover:text-orange-700 font-medium transition">
                Batal & Kembali ke Menu
            </a>
        </div>
    </div>
</div>

{{-- Script Otomatis: Jika status berubah jadi sukses, langsung pindah ke Invoice --}}
@if($order->status == 'sukses')
<script>
    setTimeout(function() {
        window.location.href = "{{ route('invoice.print', $order->id) }}";
    }, 2000);
</script>
@endif

</body>
</html>