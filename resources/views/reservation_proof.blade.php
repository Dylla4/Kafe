<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Reservasi #{{ $order->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none; }
            body { background-color: white; padding: 0; }
        }
    </style>
</head>
<body class="bg-stone-100 p-4 md:p-10 flex items-center justify-center min-h-screen">

    <div class="max-w-sm w-full bg-white shadow-xl border-t-8 border-orange-700 rounded-b-3xl overflow-hidden">
        
        {{-- Header - Disamakan dengan Receipt --}}
        <div class="p-6 text-center border-b border-dashed border-stone-200">
            <h1 class="font-black text-2xl uppercase tracking-tighter text-stone-900">Valeria Coffee</h1>
            <p class="text-[10px] text-orange-600 font-bold uppercase tracking-widest mt-1">E-Tiket Reservasi Dine-In</p>
        </div>

        <div class="p-6">
            {{-- Slot Nomor Meja - Menonjol --}}
            <div class="bg-stone-900 py-6 rounded-2xl mb-6 text-center shadow-lg">
                <p class="text-[10px] text-stone-400 uppercase font-black tracking-widest mb-1 opacity-70">Nomor Meja</p>
                <span class="text-5xl font-black text-white italic">{{ $order->nomor_meja ?? '-' }}</span>
            </div>

            {{-- Info Detail - Disamakan Style-nya --}}
            <div class="space-y-3 mb-6 border-b border-dashed border-stone-200 pb-4 text-stone-600">
                <div class="flex justify-between text-xs">
                    <span class="uppercase tracking-widest text-[10px] font-black text-stone-400">Nama Pemesan</span>
                    <span class="font-bold text-stone-900">{{ $order->nama_pembeli }}</span>
                </div>

                <div class="flex justify-between text-xs">
                    <span class="uppercase tracking-widest text-[10px] font-black text-stone-400">Metode Bayar</span>
                    <span class="px-2 py-0.5 bg-stone-100 text-stone-800 rounded text-[10px] font-black uppercase border border-stone-200">
                    {{ $order->metode_pembayaran ?? 'Cash' }}</span>
                </div>

                <div class="flex justify-between text-xs">
                    <span class="uppercase tracking-widest text-[10px] font-black text-stone-400">Waktu Booking</span>
                    <span class="font-bold text-stone-900">{{ $order->created_at->format('d/m/Y H:i') }} WIB</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="uppercase tracking-widest text-[10px] font-black text-stone-400">Kode Booking</span>
                    <span class="font-black text-orange-700 uppercase">#VAL-{{ $order->id }}{{ date('s') }}</span>
                </div>
            </div>

            {{-- Rincian Menu --}}
            <div class="mb-6">
                <p class="text-[10px] font-black text-stone-400 uppercase tracking-widest mb-3">Pesanan Pre-Order</p>
                @php 
                    $items = is_array($order->item_pesanan) ? $order->item_pesanan : json_decode($order->item_pesanan, true);
                    $itemString = "";
                @endphp
                
                <div class="space-y-3">
                    @foreach($items as $item)
                        @php $itemString .= "- " . ($item['nama_menu'] ?? $item['name']) . " (x" . ($item['quantity'] ?? $item['qty']) . ")%0D%0A"; @endphp
                        <div class="flex justify-between items-start text-sm">
                            <div class="flex-1">
                                <span class="font-bold text-stone-800">{{ $item['nama_menu'] ?? $item['name'] }}</span>
                                <span class="text-stone-400 text-xs block">{{ $item['quantity'] ?? $item['qty'] ?? 1 }}x @ Rp {{ number_format($item['harga'] ?? $item['price'], 0, ',', '.') }}</span>
                            </div>
                            <span class="font-bold text-stone-900 text-xs">Rp {{ number_format(($item['harga'] ?? $item['price']) * ($item['quantity'] ?? $item['qty'] ?? 1), 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Total --}}
            <div class="border-t-2 border-stone-900 pt-4 mb-6">
                <div class="flex justify-between items-center">
                    <span class="font-black text-xs uppercase tracking-widest">Total Bayar</span>
                    <span class="font-black text-xl text-stone-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="space-y-3 no-print">
                @php
                    $subject = "Bukti Reservasi Valeria Coffee - #" . $order->id;
                    $body = "Halo Valeria Coffee,%0D%0A%0D%0A" .
                            "Ini adalah bukti reservasi saya:%0D%0A" .
                            "Nomor Meja: " . ($order->nomor_meja ?? '-') . "%0D%0A" .
                            "Kode Booking: #VAL-" . $order->id . date('s') . "%0D%0A" .
                            "Pesanan:%0D%0A" . $itemString . "%0D%0A" .
                            "Sampai jumpa di kafe!";
                @endphp

                <div class="grid grid-cols-2 gap-2">
                    <button onclick="window.print()" class="bg-stone-900 text-white py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-stone-800 transition-all active:scale-95">
                        Cetak Tiket
                    </button>
                    <a href="mailto:valeriacoffee@email.com?subject={{ $subject }}&body={{ $body }}" 
                       class="bg-blue-600 text-white py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 transition-all active:scale-95 flex items-center justify-center">
                        Kirim Email
                    </a>
                </div>

                <a href="{{ url('/') }}" class="block text-center text-[10px] font-bold text-stone-400 uppercase tracking-widest hover:text-orange-700 transition-colors pt-2">
                    ← Kembali ke Menu Utama
                </a>
            </div>

            <div class="mt-6 text-center">
                <p class="text-[9px] text-stone-400 italic leading-relaxed">
                    *Harap tunjukkan tiket digital ini kepada kasir saat tiba.<br>
                    Meja akan disimpan selama 15 menit dari waktu booking.
                </p>
            </div>
        </div>
    </div>

</body>
</html>