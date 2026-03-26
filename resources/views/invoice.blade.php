<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Valeria Coffee - #{{ $order->id }}</title>
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
                margin: 0 auto !important; 
                padding: 5mm !important;
                width: 100% !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="bg-stone-100 p-4 md:p-10 text-stone-800 flex justify-center items-start min-h-screen">

    {{-- PERBAIKAN: border-t-[12px] diubah menjadi border-t-12 sesuai saran IntelliSense --}}
    <div class="max-w-md w-full bg-white p-8 shadow-2xl rounded-3xl border-t-12 border-[#3C2A21] receipt-card">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-black uppercase tracking-tighter text-[#3C2A21]">
                <span class="text-[#A06040]">☕</span> Valeria Coffee
            </h1>
            <p class="text-[10px] text-stone-400 uppercase font-bold tracking-[0.2em] mt-1">Quality Coffee & Roastery</p>
            <p class="text-[9px] text-stone-400 mt-2 italic">Jl. Kopi Nikmat No. 123, Indonesia</p>
        </div>

        <div class="space-y-2 text-[11px] border-y border-stone-100 py-4 mb-6">
            <div class="flex justify-between">
                <span class="text-stone-400 font-bold uppercase tracking-tighter text-[9px]">Pelanggan</span>
                <span class="font-bold text-[#3C2A21]">{{ $order->nama_pembeli }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-stone-400 font-bold uppercase tracking-tighter text-[9px]">Lokasi</span>
                <span class="font-bold">Meja {{ $order->nomor_meja }}</span>
            </div>
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
                            <span class="text-[10px] text-stone-400">@ Rp{{ number_format($item['harga']) }}</span>
                        </td>
                        <td class="text-center text-stone-500 font-bold">x{{ $item['quantity'] }}</td>
                        <td class="text-right font-bold text-stone-700 tracking-tighter">Rp{{ number_format($item['harga'] * $item['quantity']) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="border-t-2 border-dashed border-stone-200 pt-6 space-y-2">
            <div class="flex justify-between text-xs text-stone-500 font-medium">
                <span>Pembayaran</span>
                <span class="font-bold text-stone-700">Rp {{ number_format($order->bayar ?? 0) }}</span>
            </div>
            <div class="flex justify-between text-xs text-stone-500 font-medium pb-2">
                <span>Kembalian</span>
                <span class="font-bold text-stone-700">Rp {{ number_format($order->kembalian ?? 0) }}</span>
            </div>
            <div class="flex justify-between items-center pt-3 border-t border-stone-50">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400">Total Akhir</span>
                <span class="font-black text-2xl text-[#3C2A21] tracking-tighter">
                    Rp{{ number_format($order->total_harga) }}
                </span>
            </div>
        </div>

        <div class="mt-12 text-center">
            <div class="inline-block px-4 py-1 border-2 border-dashed border-stone-100 rounded-full mb-4">
                <p class="text-[9px] font-black text-stone-300 uppercase tracking-[0.3em]">Terima Kasih</p>
            </div>
            <p class="text-[10px] text-stone-400 italic">"Momen hangat di setiap pertemuan"</p>
            <div class="mt-6 opacity-10 font-black text-5xl text-stone-900 tracking-tighter">
                #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
            </div>
        </div>

        <div class="mt-10 space-y-3 no-print"> 
            <button onclick="window.print()" class="flex items-center justify-center gap-2 bg-[#3C2A21] hover:bg-[#2a1d17] text-white px-6 py-4 rounded-xl font-bold w-full transition-all active:scale-[0.98] shadow-lg">
                <span>🖨️</span> Cetak Struk
            </button>
            
            {{-- Tombol Kembali Berwarna Coklat Sesuai Permintaan --}}
            <a href="{{ url('/') }}" class="flex items-center justify-center bg-[#A06040] hover:bg-[#8d5438] text-white px-6 py-4 rounded-xl font-bold w-full text-center transition-all active:scale-[0.98] shadow-lg">
                Kembali ke Menu
            </a>
        </div>
    </div>
</body>
</html>