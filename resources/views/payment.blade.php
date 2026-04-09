<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Refresh otomatis hanya jika status masih pending/menunggu --}}
    @if($order->status == 'pending')
        <meta http-equiv="refresh" content="10">
    @endif
</head>
<body class="bg-stone-50 text-stone-800 font-sans p-6 flex items-center justify-center min-h-screen">

<div class="max-w-md w-full bg-white rounded-3xl shadow-2xl overflow-hidden border border-stone-100">
    {{-- Header --}}
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
            // Status sukses berarti sudah dikonfirmasi
            $isSuccess = in_array(strtolower($order->status), ['sukses', 'diproses', 'selesai']);
        @endphp

        <div class="min-h-55 flex flex-col justify-center">
            @if($method == 'qris')
                <div class="text-center">
                    <p class="text-sm font-bold text-stone-600 mb-4 uppercase tracking-widest">Scan QRIS Di Bawah Ini</p>
                    <div class="bg-white p-4 rounded-3xl border-2 border-orange-100 inline-block shadow-sm">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=VALERIA-{{ $order->id }}" class="w-52 h-52 mx-auto">
                    </div>
                </div>
            @elseif($method == 'transfer')
                <div class="text-center space-y-4">
                    <div class="bg-stone-50 p-6 rounded-3xl border-2 border-dashed border-stone-200">
                        <p class="text-sm font-bold text-stone-600 uppercase tracking-widest mb-3">Transfer Bank</p>
                        <div class="space-y-2">
                            <p class="text-xs text-stone-500 uppercase font-bold">Nomor Rekening BCA</p>
                            <p class="text-2xl font-black text-stone-800 tracking-wider">123 456 7890</p>
                            <p class="text-sm text-stone-600 font-medium">A/N Valeria Coffee</p>
                        </div>
                    </div>
                </div>
            @else
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
                <a href="{{ route('invoice.print', $order->id) }}" target="_blank" class="block text-center w-full bg-green-600 text-white py-4 rounded-2xl font-black hover:bg-green-700 transition shadow-lg">
                    CETAK ULANG STRUK
                </a>
            @else
                {{-- Tombol Konfirmasi menggunakan Button (Bukan Form) agar dikontrol JS --}}
                <button id="btn-konfirmasi-tunai" class="w-full py-4 bg-green-600 text-white rounded-2xl font-bold uppercase tracking-widest hover:bg-green-700 shadow-lg transition-all active:scale-95">
                    Konfirmasi Pembayaran
                </button>
            @endif

            <a href="{{ route('order.history') }}" class="block text-center w-full bg-stone-900 text-white py-4 rounded-2xl font-bold uppercase tracking-wider hover:bg-stone-800 transition shadow-md">
                Cek Status Riwayat
            </a>
        </div>
    </div>
</div>

<script>
    const btnKonfirmasi = document.getElementById('btn-konfirmasi-tunai');
    
    if(btnKonfirmasi) {
        btnKonfirmasi.addEventListener('click', function() {
            const orderId = "{{ $order->id }}";

            if(confirm('Apakah Anda sudah membayar atau ingin mengonfirmasi pesanan ini?')) {
                // UI Loading
                btnKonfirmasi.disabled = true;
                btnKonfirmasi.innerText = "MEMPROSES...";

                fetch(`/payment/confirm/${orderId}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // 1. Buka invoice di tab baru
                        window.open(`/invoice/${orderId}`, '_blank');
                        
                        // 2. Refresh halaman ke history untuk melihat status terbaru
                        window.location.href = "{{ route('order.history') }}";
                    } else {
                        alert("Gagal: " + data.message);
                        btnKonfirmasi.disabled = false;
                        btnKonfirmasi.innerText = "Konfirmasi Pembayaran";
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan koneksi ke server.");
                    btnKonfirmasi.disabled = false;
                    btnKonfirmasi.innerText = "Konfirmasi Pembayaran";
                });
            }
        });
    }
</script>

</body>
</html>