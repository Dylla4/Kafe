<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Valeria Coffee - {{ $order->nomor_pesanan }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&family=Courier+Prime&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono-receipt { font-family: 'Courier Prime', monospace; }
        
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; margin: 0 !important; }
            .receipt-card { 
                box-shadow: none !important; 
                border: none !important; 
                margin: 0 !important; 
                padding: 5mm !important;
                width: 100% !important;
                max-width: 80mm !important;
            }
        }
    </style>
</head>

<body class="bg-stone-100 p-4 md:p-10 text-stone-800 flex justify-center items-start min-h-screen">

    @php
        $items = is_array($order->item_pesanan) ? $order->item_pesanan : json_decode($order->item_pesanan, true);
        
        // Menyusun teks rincian item untuk isi email
        $itemDetails = "";
        foreach($items as $item) {
            $itemDetails .= "- " . ($item['nama_menu'] ?? 'Menu') . " (x" . ($item['quantity'] ?? 1) . ")%0D%0A";
        }
    @endphp

    <div class="max-w-md w-full bg-white p-8 shadow-2xl rounded-3xl border-t-12 border-[#3C2A21] receipt-card">
        
        {{-- Header Struk --}}
        <div class="text-center mb-8">
            <h1 class="text-2xl font-black uppercase tracking-tighter text-[#3C2A21]">
                <span class="text-[#A06040]">☕</span> Valeria Coffee
            </h1>
            <p class="text-[10px] text-stone-400 uppercase font-bold tracking-[0.2em] mt-1">Quality Coffee & Roastery</p>
            <p class="text-[9px] text-stone-400 mt-2 italic">Jl. Kopi Nikmat No. 123, Indonesia</p>
        </div>

        {{-- Info Pesanan --}}
        <div class="space-y-3 text-[11px] border-y border-stone-100 py-4 mb-6">
            <div class="flex justify-between">
                <span class="text-stone-400 font-bold uppercase tracking-tighter text-[9px]">No. Pesanan</span>
                <span class="font-bold text-[#3C2A21]">{{ $order->nomor_pesanan }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-stone-400 font-bold uppercase tracking-tighter text-[9px]">Pelanggan</span>
                <span class="font-bold text-[#3C2A21]">{{ $order->nama_pembeli }}</span>
            </div>
            
            @if($order->nomor_meja)
            <div class="flex justify-between">
                <span class="text-stone-400 font-bold uppercase tracking-tighter text-[9px]">Nomor Meja</span>
                <span class="font-bold text-[#A06040]">{{ $order->nomor_meja }}</span>
            </div>
            @else
            <div class="flex justify-between">
                <span class="text-stone-400 font-bold uppercase tracking-tighter text-[9px]">Layanan</span>
                <span class="font-bold text-blue-600 uppercase text-[9px]">Take Away / Delivery</span>
            </div>
            @endif

            <div class="flex justify-between">
                <span class="text-stone-400 font-bold uppercase tracking-tighter text-[9px]">Waktu</span>
                <span class="font-medium text-stone-500">{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>

            <div class="flex justify-between items-center">
                <span class="text-stone-400 font-bold uppercase tracking-tighter text-[9px]">Metode</span>
                <span class="px-2 py-0.5 bg-orange-50 text-[#A06040] rounded-md text-[9px] font-black uppercase tracking-widest border border-orange-100">
                    {{ strtoupper($order->metode_pembayaran) }}
                </span>
            </div>
        </div>

        {{-- Tabel Menu --}}
        <div class="font-mono-receipt text-xs mb-8">
            <table class="w-full">
                <thead class="border-b border-dashed border-stone-200">
                    <tr class="text-stone-400 text-[10px] uppercase">
                        <th class="text-left py-2 font-normal">Item</th>
                        <th class="text-center py-2 font-normal">Qty</th>
                        <th class="text-right py-2 font-normal">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dashed divide-stone-100">
                    @foreach($items as $item)
                    <tr>
                        <td class="py-3 pr-2 leading-tight">
                            <span class="block font-bold text-stone-700 uppercase tracking-tighter">{{ $item['nama_menu'] }}</span>
                            <span class="text-[10px] text-stone-400">@ Rp{{ number_format($item['harga'], 0, ',', '.') }}</span>
                        </td>
                        <td class="text-center text-stone-500 font-bold font-sans">x{{ $item['quantity'] }}</td>
                        <td class="text-right font-bold text-stone-700 tracking-tighter">Rp{{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Total & Pembayaran --}}
        <div class="border-t-2 border-dashed border-stone-200 pt-6 space-y-2">
            <div class="flex justify-between text-xs text-stone-500 font-medium">
                <span>Total Item</span>
                <span class="font-bold text-stone-700">{{ collect($items)->sum('quantity') }}</span>
            </div>
            <div class="flex justify-between items-center pt-3 border-t border-stone-50">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400">Total Akhir</span>
                <span class="font-black text-2xl text-[#3C2A21] tracking-tighter">
                    Rp{{ number_format($order->total_harga, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Footer Struk --}}
        <div class="mt-12 text-center">
            <div class="inline-block px-4 py-1 border-2 border-dashed border-stone-100 rounded-full mb-4">
                <p class="text-[9px] font-black text-stone-300 uppercase tracking-[0.3em]">Terima Kasih</p>
            </div>
            <p class="text-[10px] text-stone-400 italic">"Momen hangat di setiap pertemuan"</p>
            
            <div class="mt-6 opacity-10 font-black text-4xl text-stone-900 tracking-tighter uppercase">
                {{ $order->nomor_pesanan }}
            </div>
        </div>

        {{-- Navigasi Tombol Opsi (Tidak Diprint) --}}
        <div class="mt-10 space-y-3 no-print"> 
            <button onclick="window.print()" class="flex items-center justify-center gap-2 bg-[#3C2A21] hover:bg-[#2a1d17] text-white px-6 py-4 rounded-xl font-bold w-full transition-all active:scale-[0.95] shadow-lg">
                <span>🖨️</span> Cetak Struk Fisik
            </button>
            
            {{-- Perubahan mailto: --}}
            <a href="mailto:?subject=Struk Belanja Valeria Coffee - {{ $order->nomor_pesanan }}&body=Halo {{ $order->nama_pembeli }},%0D%0A%0D%0ABerikut adalah rincian pesanan Anda di Valeria Coffee:%0D%0A%0D%0ANomor Pesanan: {{ $order->nomor_pesanan }}%0D%0ATotal Bayar: Rp{{ number_format($order->total_harga, 0, ',', '.') }}%0D%0A%0D%0ARincian Item:%0D%0A{!! $itemDetails !!}%0D%0ATerima kasih atas kunjungan Anda!" 
               class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-xl font-bold w-full transition-all active:scale-[0.95] shadow-lg">
                <span>📧</span> Kirim Struk ke Email
            </a>
            
            <a href="{{ url('/') }}" class="flex items-center justify-center bg-[#A06040] hover:bg-[#8d5438] text-white px-6 py-4 rounded-xl font-bold w-full text-center transition-all active:scale-[0.95] shadow-lg">
                Kembali ke Menu
            </a>
        </div>
    </div>
</body>
</html>