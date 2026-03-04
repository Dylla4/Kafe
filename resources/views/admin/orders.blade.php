<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-teal-admin { background-color: #008080; }
        .text-panel-red { color: #ff4d4d; }
    </style>
</head>
<body class="flex bg-gray-100 min-h-screen">

    <div class="w-64 bg-teal-admin text-white shrink-0 p-6 flex flex-col sticky top-0 h-screen">
        <h1 class="text-2xl font-bold text-panel-red">Admin<span class="text-white">Panel</span></h1>
        <p class="text-xs opacity-80 mb-8 uppercase tracking-widest font-bold">Valeria Coffee</p>
        
        <nav class="flex-1 space-y-2 text-sm">
            <p class="text-[10px] uppercase font-bold opacity-50 mb-2 tracking-widest">Menu Utama</p>
            
            <a href="{{ route('admin.orders') }}" class="flex items-center p-3 rounded-lg hover:bg-white/10 transition {{ request()->is('admin/orders') ? 'bg-white/20 font-bold' : '' }}">
                <span class="mr-3">📋</span> Daftar Pesanan
            </a>

            <a href="#stats-section" class="flex items-center p-3 rounded-lg hover:bg-white/10 transition">
                <span class="mr-3">📊</span> Statistik Harian
            </a>

            <div class="pt-4 mt-4 border-t border-white/10">
                <a href="{{ route('home') }}" class="block py-2 opacity-70 hover:opacity-100 font-semibold italic text-orange-200">
                    ← Kembali ke Menu
                </a>
            </div>
        </nav>
    </div>

    <div class="flex-1 p-10">
        
        <div id="stats-section" class="mb-10">
            <h2 class="text-2xl font-bold mb-6 flex items-center text-gray-800 tracking-tight">
                <span class="mr-2">📈</span> Ringkasan Penjualan Hari Ini
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-7 rounded-3xl shadow-sm border-l-8 border-teal-500">
                    <p class="text-xs text-gray-400 font-black uppercase tracking-widest">Total Pesanan</p>
                    <h3 class="text-5xl font-black text-stone-800 mt-1">{{ count($orders) }}</h3>
                    <p class="text-[10px] text-teal-600 mt-2 font-bold uppercase italic">Data Terpusat di MySQL</p>
                </div>

                <div class="bg-white p-7 rounded-3xl shadow-sm border-l-8 border-green-500">
                    <p class="text-xs text-gray-400 font-black uppercase tracking-widest">Pendapatan (Rp)</p>
                    <h3 class="text-5xl font-black text-stone-800 mt-1">{{ number_format($orders->sum('total_harga')) }}</h3>
                    <p class="text-[10px] text-green-600 mt-2 font-bold uppercase italic">Total dari Semua Status</p>
                </div>
            </div>
        </div>

        <hr class="mb-10 border-gray-200">

        <div id="list-section">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-black text-stone-900 tracking-tighter">📦 Semua Daftar Order</h2>
                <div class="bg-white px-4 py-2 rounded-xl border text-sm font-bold text-stone-500">
                    {{ now()->format('d F Y') }}
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-600 text-white p-4 rounded-2xl mb-8 shadow-lg font-bold flex items-center gap-3 animate-bounce">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif

            @if($orders->isEmpty())
                <div class="bg-white p-20 rounded-[2.5rem] shadow-sm border-2 border-dashed text-center text-gray-400">
                    <p class="text-6xl mb-4">☕</p>
                    <p class="font-bold text-lg">Belum ada data pesanan di database MySQL.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-4">
                    @foreach($orders as $order)
                        @php
                            $status = $order->status ?? 'diproses';
                            $badgeColor = match ($status) {
                                'diproses' => 'bg-blue-100 text-blue-700 border-blue-200',
                                'siap' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                'selesai' => 'bg-green-100 text-green-700 border-green-200',
                                'menunggu_pembayaran' => 'bg-orange-100 text-orange-700 border-orange-200',
                                default => 'bg-gray-100 text-gray-700 border-gray-200',
                            };
                        @endphp

                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="font-black text-xl text-stone-900">#{{ $order->id }}</span>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border {{ $badgeColor }}">
                                        {{ str_replace('_', ' ', $status) }}
                                    </span>
                                </div>
                                <h4 class="font-bold text-stone-800 text-lg leading-tight">{{ $order->nama_pembeli }}</h4>
                                <p class="text-xs text-stone-400 font-bold uppercase tracking-widest mt-1">
                                    {{ $order->metode_pembayaran }} • Meja: {{ $order->nomor_meja ?? '-' }}
                                </p>
                            </div>

                            <div class="text-left md:text-center px-6 border-l border-stone-100">
                                <p class="text-[10px] text-stone-400 font-bold uppercase">Tagihan</p>
                                <p class="font-black text-orange-700 text-xl">Rp {{ number_format($order->total_harga) }}</p>
                            </div>

                            <div class="flex items-center gap-3 w-full md:w-auto">
                                <form action="{{ route('orders.status', $order->id) }}" method="POST" class="flex-1 md:flex-none">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="w-full text-xs font-bold border-2 border-stone-100 rounded-xl px-4 py-2.5 bg-stone-50 outline-none focus:border-orange-200 transition">
                                        <option value="menunggu_pembayaran" {{ $status === 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Bayar</option>
                                        <option value="diproses" {{ $status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="siap" {{ $status === 'siap' ? 'selected' : '' }}>Siap Disajikan</option>
                                        <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </form>

                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan #{{ $order->id }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition shadow-sm border border-red-100">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</body>
</html>