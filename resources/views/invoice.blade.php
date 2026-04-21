<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->nomor_pesanan }} - Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Courier+Prime&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-receipt { font-family: 'Courier Prime', monospace; }
        @media print {
            .no-print { display: none !important; }
            body { background-color: white; padding: 0; }
            .receipt-card { box-shadow: none !important; border: 1px solid #eee !important; }
        }
    </style>
</head>
<body class="bg-stone-100 p-4 md:p-10 flex items-center justify-center min-h-screen">

    <div class="max-w-sm w-full bg-white shadow-2xl border-t-[12px] border-[#3C2A21] rounded-b-3xl overflow-hidden receipt-card">
        
        {{-- Header Section --}}
        <div class="p-6 text-center border-b border-dashed border-stone-200">
            <h1 class="font-black text-2xl uppercase tracking-tighter text-[#3C2A21]">Valeria Coffee</h1>
            <p class="text-[10px] text-[#A06040] font-bold uppercase tracking-[0.2em] mt-1">Quality Coffee & Roastery</p>
        </div>

        <div class="p-6">
            {{-- Box Informasi Utama (Dinamis Berdasarkan Jenis Pesanan) --}}
            <div class="bg-stone-900 py-6 px-4 rounded-2xl mb-6 text-center shadow-lg text-white">
                @if($order->jenis_pesanan === 'dine_in')
                    <p class="text-[10px] text-stone-400 uppercase font-black tracking-widest mb-1 opacity-70">Nomor Meja</p>
                    <span class="text-5xl font-black italic text-[#A06040]">{{ $order->nomor_meja ?? '-' }}</span>
                @elseif($order->jenis_pesanan === 'delivery')
                    <p class="text-[10px] text-stone-400 uppercase font-black tracking-widest mb-1 opacity-70">Alamat Pengiriman</p>
                    <span class="text-sm font-bold leading-tight block px-2">{{ $order->alamat }}</span>
                @else
                    <p class="text-[10px] text-stone-400 uppercase font-black tracking-widest mb-1 opacity-70">Nomor Pesanan</p>
                    <span class="text-3xl font-black italic text-[#A06040]">#{{ $order->nomor_pesanan }}</span>
                @endif
            </div>

            {{-- Detail Informasi --}}
            <div class="space-y-3 mb-6 border-b border-dashed border-stone-200 pb-4 text-stone-600">
                <div class="flex justify-between text-xs">
                    <span class="uppercase tracking-widest text-[9px] font-black text-stone-400">Pemesan</span>
                    <span class="font-bold text-stone-900">{{ $order->nama_pemesan }}</span>
                </div>

                <div class="flex justify-between text-xs">
                    <span class="uppercase tracking-widest text-[9px] font-black text-stone-400">Layanan</span>
                    <span class="font-bold text-[#A06040] uppercase">
                        {{ str_replace('_', ' ', $order->jenis_pesanan) }}
                    </span>
                </div>

                <div class="flex justify-between text-xs">
                    <span class="uppercase tracking-widest text-[9px] font-black text-stone-400">Waktu</span>
                    <span class="font-bold text-stone-900">{{ $order->created_at->format('d/m/Y H:i') }} WIB</span>
                </div>
            </div>

            {{-- Rincian Menu (Font Mono ala Struk) --}}
            <div class="mb-6 font-receipt">
                <p class="text-[10px] font-black text-stone-400 uppercase tracking-widest mb-3 font-sans">Rincian Item</p>
                @php 
                    $items = is_array($order->item_pesanan) ? $order->item_pesanan : json_decode($order->item_pesanan, true);
                    $waItemString = "";
                @endphp
                
                <div class="space-y-3">
                    @foreach($items as $item)
                        @php 
                            $nama = $item['nama_menu'] ?? $item['name'];
                            $qty = $item['quantity'] ?? $item['qty'];
                            $harga = $item['harga'] ?? $item['price'];
                            $waItemString .= "• " . $nama . " (x" . $qty . ")\n"; 
                        @endphp
                        <div class="flex justify-between items-start text-xs">
                            <div class="flex-1">
                                <span class="font-bold text-stone-800 uppercase">{{ $nama }}</span>
                                <span class="text-stone-400 text-[10px] block">{{ $qty }}x @ {{ number_format($harga, 0, ',', '.') }}</span>
                            </div>
                            <span class="font-bold text-stone-900 italic">{{ number_format($harga * $qty, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Total Akhir --}}
            <div class="border-t-2 border-[#3C2A21] pt-4 mb-8">
                <div class="flex justify-between items-center">
                    <span class="font-black text-[10px] uppercase tracking-widest text-stone-400">Total Bayar</span>
                    <span class="font-black text-2xl text-[#3C2A21]">Rp{{ number_format($order->total_bayar ?? $order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Tombol Aksi (Tidak Diprint) --}}
            <div class="space-y-3 no-print">
                @php
                    $adminPhone = "6282115937845"; // Ganti dengan nomor WhatsApp Kafe
                    
                    $waHeader = ($order->jenis_pesanan === 'dine_in') ? "*E-TIKET RESERVASI*" : "*STRUK PESANAN ONLINE*";
                    $waLayananInfo = ($order->jenis_pesanan === 'dine_in') ? "Meja: " . $order->nomor_meja : ($order->jenis_pesanan === 'delivery' ? "Alamat: " . $order->alamat : "Layanan: Take Away");

                    $waMessage = $waHeader . " - VALERIA COFFEE\n";
                    $waMessage .= "----------------------------------\n";
                    $waMessage .= "No: #" . $order->nomor_pesanan . "\n";
                    $waMessage .= "Nama: " . $order->nama_pemesan . "\n";
                    $waMessage .= $waLayananInfo . "\n";
                    $waMessage .= "----------------------------------\n";
                    $waMessage .= "*PESANAN:*\n" . $waItemString;
                    $waMessage .= "\n*TOTAL: Rp " . number_format($order->total_bayar ?? $order->total_harga, 0, ',', '.') . "*\n";
                    $waMessage .= "----------------------------------\n";
                    $waMessage .= "Terima kasih telah memesan!";

                    $waUrl = "https://wa.me/" . $adminPhone . "?text=" . urlencode($waMessage);
                @endphp

                <button onclick="window.print()" class="w-full bg-stone-900 text-white py-4 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-black transition-all active:scale-95 shadow-lg">
                    Cetak Struk Fisik
                </button>

                <a href="{{ $waUrl }}" target="_blank" class="w-full bg-[#25D366] text-white py-4 rounded-2xl text-xs font-black uppercase tracking-widest flex items-center justify-center hover:bg-[#20ba59] transition-all active:scale-95 shadow-lg">
                    Konfirmasi WhatsApp
                </a>

                <a href="{{ url('/') }}" class="block text-center text-[10px] font-bold text-stone-400 uppercase tracking-widest hover:text-[#A06040] transition-colors pt-2">
                    ← Kembali ke Beranda
                </a>
            </div>

            {{-- Footer Note --}}
            <div class="mt-8 text-center border-t border-stone-50 pt-4">
                <p class="text-[9px] text-stone-400 italic leading-relaxed">
                    "Momen hangat di setiap pertemuan"<br>
                    Simpan struk ini sebagai bukti pembayaran sah.
                </p>
            </div>
        </div>
    </div>

</body>
</html>