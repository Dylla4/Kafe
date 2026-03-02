<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Kafe Kita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-teal-admin { background-color: #008080; }
        .text-panel-red { color: #ff4d4d; }
    </style>
</head>
<body class="flex bg-gray-100 min-h-screen">

    <div class="w-64 bg-teal-admin text-white shrink-0 p-6 flex flex-col">
        <h1 class="text-2xl font-bold text-panel-red">Admin<span class="text-white">Panel</span></h1>
        <p class="text-xs opacity-80 mb-8">Valeria Coffee</p>
        
        <nav class="flex-1 space-y-2 text-sm">
            <p class="text-[10px] uppercase font-bold opacity-50 mb-2 tracking-widest">Menu Utama</p>
            
            <a href="{{ url('/admin/orders') }}" class="flex items-center p-3 rounded-lg hover:bg-white/10 transition {{ request()->is('admin/orders') ? 'bg-white/20 font-bold' : '' }}">
                <span class="mr-3">📋</span> Daftar Pesanan
            </a>

            <a href="#stats-section" class="flex items-center p-3 rounded-lg hover:bg-white/10 transition">
                <span class="mr-3">📊</span> Pesanan Per Hari
            </a>

            <div class="pt-4 mt-4 border-t border-white/10">
                <a href="#" class="block py-2 opacity-70 hover:opacity-100">Main page</a>
                <a href="#" class="block py-2 opacity-70 hover:opacity-100">Official page</a>
            </div>
        </nav>
    </div>

    <div class="flex-1 p-10 overflow-y-auto">
        
        <div id="stats-section" class="mb-10">
            <h2 class="text-2xl font-bold mb-6 flex items-center text-gray-800">
                <span class="mr-2">📈</span> Ringkasan Hari Ini
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-8 border-teal-500">
                    <p class="text-sm text-gray-500 font-bold uppercase">Total Pesanan</p>
                    <h3 class="text-4xl font-black text-gray-800">{{ $jumlahPesananHariIni ?? 0 }}</h3>
                    <p class="text-[10px] text-gray-400 mt-2 uppercase">Update Real-time Firebase</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-8 border-green-500">
                    <p class="text-sm text-gray-500 font-bold uppercase">Pendapatan (Rp)</p>
                    <h3 class="text-4xl font-black text-gray-800">{{ number_format($totalPendapatanHariIni ?? 0) }}</h3>
                    <p class="text-[10px] text-gray-400 mt-2 uppercase">Berdasarkan total_harga</p>
                </div>
            </div>
        </div>

        <hr class="mb-10 border-gray-200">

        <div id="list-section">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">📦 Semua Daftar Order</h2>
                <button class="bg-green-700 text-white px-5 py-2 rounded-lg font-bold text-sm hover:bg-green-800 transition">
                    + Add New
                </button>
            </div>

            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded-xl mb-6 shadow-md">
                    {{ session('success') }}
                </div>
            @endif

            @if(empty($orders))
                <div class="bg-white p-10 rounded-2xl shadow text-center text-gray-400">
                    Belum ada data pesanan di Firebase.
                </div>
            @else
                <div class="space-y-4">
                    @foreach($orders as $id => $order)
                        @php
                            $status = $order['status'] ?? 'diproses';
                            $status = is_string($status) ? $status : 'diproses';

                            $badgeColor = match ($status) {
                                'diproses' => 'bg-blue-500',
                                'siap' => 'bg-yellow-500',
                                'selesai' => 'bg-green-600',
                                default => 'bg-gray-500',
                            };
                        @endphp

                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                            <div class="flex-1">
                                <div class="flex items-center mb-1">
                                    <span class="font-black text-lg mr-3">#{{ $id }}</span>
                                    <span class="px-2 py-0.5 rounded text-[10px] text-white font-bold uppercase {{ $badgeColor }}">
                                        {{ $status }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-700 font-medium">
                                    {{ $order['nama_pembeli'] ?? ($order['nama'] ?? 'Pelanggan') }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Total: <span class="font-bold text-gray-800 text-sm">Rp {{ number_format($order['total_harga'] ?? 0) }}</span>
                                </p>
                            </div>

                            <div class="flex items-center space-x-4">
                                <form action="{{ url('/orders/'.$id.'/status') }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="text-xs border rounded-lg px-2 py-1 bg-gray-50 outline-none">
                                        <option value="diproses" {{ $status === 'diproses' ? 'selected' : '' }}>Proses</option>
                                        <option value="siap" {{ $status === 'siap' ? 'selected' : '' }}>Siap</option>
                                        <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </form>
                                <button class="text-red-500 text-xs font-bold hover:underline">Hapus</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</body>
</html>