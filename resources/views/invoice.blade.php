<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Valeria Coffee - {{ $order->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; }
        }
    </style>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-md mx-auto bg-white p-8 shadow-lg border-t-8 border-orange-700">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold uppercase">☕ Valeria Coffee</h1>
            <p class="text-sm text-gray-500">Jl. Kopi Nikmat No. 123, Indonesia</p>
        </div>

        <div class="border-b-2 border-dashed py-4 text-sm space-y-1">
            <p><strong>Pelanggan:</strong> {{ $order->nama_pembeli }}</p>
            <p><strong>Lokasi:</strong> {{ $order->nomor_meja }}</p>
            <p><strong>Waktu:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <table class="w-full text-sm my-6">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Item</th>
                    <th class="text-center py-2">Qty</th>
                    <th class="text-right py-2">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td class="py-2">{{ $item['nama_menu'] }}</td>
                    <td class="text-center">{{ $item['quantity'] }}</td>
                    <td class="text-right">Rp {{ number_format($item['harga'] * $item['quantity']) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="border-t-2 border-dashed pt-4 flex justify-between font-bold text-lg text-orange-700">
            <span>TOTAL</span>
            <span>Rp {{ number_format($order->total_harga) }}</span>
        </div>

        <div class="mt-8 text-center text-xs text-gray-400">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>Valeria Coffee - Momen hangat di setiap pertemuan</p>
        </div>

        <div class="mt-8 flex gap-2 no-print">
            <button onclick="window.print()" class="bg-orange-700 text-white px-6 py-2 rounded-lg font-bold w-full">🖨️ Cetak Struk</button>
            <a href="{{ url('/') }}" class="bg-gray-200 text-gray-600 px-6 py-2 rounded-lg font-bold w-full text-center italic">Kembali</a>
        </div>
    </div>
</body>
</html>