<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan #{{ $order->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', 'Mono', sans-serif; }
        @media print {
            .no-print { display: none; }
            body { background-color: white; padding: 0; }
            .shadow-md { shadow: none; border: 1px solid #eee; }
        }
    </style>
</head>
<body class="bg-stone-100 p-4 md:p-10">
    <div class="max-w-sm mx-auto bg-white p-6 shadow-xl border-t-8 border-orange-700 rounded-b-3xl">
        
        {{-- Header --}}
        <div class="text-center mb-6">
            <h1 class="font-black text-2xl uppercase tracking-tighter text-stone-900">Valeria Coffee</h1>
            <p class="text-[10px] text-stone-400 font-bold uppercase tracking-widest mt-1">Struk Resmi Pembayaran</p>
        </div>

        {{-- Info Pesanan --}}
        <div class="border-b border-dashed border-stone-200 pb-4 mb-4 space-y-2 text-stone-600">
            <div class="flex justify-between text-xs">
                <span>No. Pesanan:</span>
                <span class="font-bold text-stone-900">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>

            <div class="flex justify-between text-xs items-center">
                <span>Metode Bayar:</span>
                <span class="px-2 py-0.5 bg-stone-100 text-stone-800 rounded text-[10px] font-black uppercase border border-stone-200">
                {{ $order->metode_pembayaran ?? 'Cash' }}</span>
            </div>

            <div class="flex justify-between text-xs">
                <span>Layanan:</span>
                <span class="font-bold text-orange-700 uppercase">
                    {{ $order->nomor_meja ? 'Dine In (Meja ' . $order->nomor_meja . ')' : 'Take Away' }}
                </span>
            </div>
            <div class="flex justify-between text-xs">
                <span>Waktu:</span>
                <span>{{ $order->created_at->format('d/m/Y H:i') }} WIB</span>
            </div>
        </div>

        {{-- Rincian Menu --}}
        <div class="mb-4">
            <p class="text-[10px] font-black text-stone-400 uppercase tracking-widest mb-3">Rincian Menu</p>
            @php
                $items = is_array($order->item_pesanan) ? $order->item_pesanan : json_decode($order->item_pesanan, true);
                $itemString = "";
            @endphp
            
            <div class="space-y-3">
                @foreach($items as $item)
                    @php $itemString .= "- " . $item['nama_menu'] . " (x" . $item['quantity'] . ")%0D%0A"; @endphp
                    <div class="flex justify-between items-start text-sm">
                        <div class="flex-1">
                            <span class="font-bold text-stone-800">{{ $item['nama_menu'] }}</span>
                            <span class="text-stone-400 text-xs block">{{ $item['quantity'] }}x @ Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                        </div>
                        <span class="font-bold text-stone-900">Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Alamat / Catatan --}}
        @if($order->alamat)
        <div class="border-t border-dashed border-stone-200 pt-4 mb-4">
            <p class="text-[10px] font-black text-stone-400 uppercase tracking-widest mb-1">Alamat / Catatan</p>
            <p class="text-xs leading-relaxed text-stone-600">{{ $order->alamat }}</p>
        </div>
        @endif

        {{-- Total --}}
        <div class="border-t-2 border-stone-900 pt-4 mb-6">
            <div class="flex justify-between items-center">
                <span class="font-black text-xs uppercase tracking-widest">Total Bayar</span>
                <span class="font-black text-xl text-stone-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Footer & Action --}}
<div class="text-center space-y-4 no-print">
    <p class="text-[9px] text-stone-400 leading-tight italic">
        Harap tunjukkan struk digital ini ke kasir<br>saat pengambilan pesanan.
    </p>

    @php
        // 1. Susun daftar menu jadi teks bersih (pakai \n untuk baris baru)
        $items = is_array($order->item_pesanan) ? $order->item_pesanan : json_decode($order->item_pesanan, true);
        $menuText = "";
        foreach($items as $item) {
            $menuText .= "- " . $item['nama_menu'] . " (x" . $item['quantity'] . ")\n";
        }

        // 2. Susun template pesan lengkap
        $rawSubject = "Bukti Pesanan Valeria Coffee - #" . str_pad($order->id, 4, '0', STR_PAD_LEFT);
        $rawBody = "Halo Valeria Coffee,\n\n" .
                   "Berikut detail pesanan saya:\n" .
                   "No. Pesanan: #" . str_pad($order->id, 4, '0', STR_PAD_LEFT) . "\n" .
                   "Metode Bayar: " . ($order->metode_pembayaran ?? 'Cash') . "\n" .
                   "Layanan: " . ($order->nomor_meja ? 'Dine In (Meja '.$order->nomor_meja.')' : 'Take Away') . "\n\n" .
                   "Pesanan:\n" . $menuText . "\n" .
                   "Total Bayar: Rp " . number_format($order->total_harga, 0, ',', '.') . "\n\n" .
                   "Terima Kasih.";

        // 3. ENCODE WAJIB agar Chrome tidak buka Tab Kosong
        $subject = rawurlencode($rawSubject);
        $body = rawurlencode($rawBody);
    @endphp

    <div class="grid grid-cols-2 gap-2">
        <button onclick="window.print()" class="bg-stone-900 text-white py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-stone-800 transition-all active:scale-95">
            Cetak Struk
        </button>
        {{-- Link Mailto yang sudah di-encode --}}
        <button type="button" 
        onclick="confirmAndSend()"
        class="bg-blue-600 text-white py-3 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center w-full">
    Kirim Email
</button>

<script>
function confirmAndSend() {
    // Membuka window baru khusus mailto
    const mailtoUrl = "mailto:valeriacoffee@email.com?subject={{ $subject }}&body={{ $body }}";
    window.location.href = mailtoUrl;
}
</script>
    </div>
    
    <a href="{{ route('menu') }}" class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest hover:text-orange-700 transition-colors pt-2">
        ← Kembali ke Menu
    </a>
</div>
    </div>
</body>
</html>