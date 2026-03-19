<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan - Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        .bg-coffee-admin { background-color: #3C2A21; }
        .text-accent-caramel { color: #A06040; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="flex bg-[#FDFBF7] min-h-screen text-[#3C2A21]">

    <div class="w-64 bg-coffee-admin text-[#FDFBF7] shrink-0 p-6 flex flex-col sticky top-0 h-screen shadow-2xl">
        <h1 class="text-2xl font-black tracking-tighter text-accent-caramel uppercase text-center">Valeria<span class="text-white opacity-50">Admin</span></h1>
        <p class="text-[10px] opacity-50 mb-8 uppercase tracking-[0.3em] font-bold text-center">Coffee Control Center</p>
        
        <nav class="flex-1 space-y-2 text-sm">
            <a href="{{ route('admin.orders') }}" class="flex items-center p-3 rounded-xl bg-white/10 border-l-4 border-accent-caramel font-bold transition text-white">
                <span class="mr-3">☕</span> Riwayat Pesanan
            </a>
            <div class="pt-4 mt-4 border-t border-white/5">
                <a href="{{ url('/') }}" class="block py-2 opacity-50 hover:opacity-100 font-bold text-xs uppercase tracking-widest transition">← Lihat Toko</a>
            </div>
        </nav>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto pt-4 border-t border-white/5">
            @csrf
            <button type="submit" class="w-full flex items-center p-3 rounded-xl bg-red-500/10 hover:bg-red-600 text-red-400 hover:text-white transition font-bold text-[10px] uppercase tracking-widest">
                <span class="mr-3">🚪</span> Logout
            </button>
        </form>
    </div>

    <div class="flex-1 p-10">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border-b-8 border-accent-caramel">
                <p class="text-[10px] text-stone-400 font-black uppercase tracking-[0.2em] mb-2">Orders Today</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-7xl font-black text-[#3C2A21]">{{ count($ordersToday ?? []) }}</h3>
                    <span class="text-stone-400 font-bold uppercase text-xs">Pesanan</span>
                </div>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border-b-8 border-[#3C2A21]">
                <p class="text-[10px] text-stone-400 font-black uppercase tracking-[0.2em] mb-2">Revenue Today</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-6xl font-black text-[#3C2A21]">Rp{{ number_format(($ordersToday ?? collect())->sum('total_harga')) }}</h3>
                </div>
            </div>
        </div>

        <div class="mb-16">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-black text-[#3C2A21] tracking-tighter uppercase">📦 Daftar Pesanan Terbaru</h2>
                <div class="bg-[#3C2A21] px-6 py-2 rounded-full text-[10px] font-bold text-white tracking-[0.2em] shadow-lg uppercase">
                    Total Data: {{ $orders->count() }}
                </div>
            </div>

            <div class="space-y-4 max-h-150 overflow-y-auto pr-2 custom-scrollbar">
                @forelse($orders as $order)
                    @php
                        $status = $order->status ?? 'diproses';
                        $badgeColor = match ($status) {
                            'diproses', 'process' => 'bg-blue-50 text-blue-600 border-blue-100',
                            'siap', 'ready' => 'bg-amber-50 text-amber-600 border-amber-100',
                            'selesai', 'done', 'sukses' => 'bg-green-50 text-green-600 border-green-200',
                            default => 'bg-stone-50 text-stone-600 border-stone-100',
                        };
                    @endphp
                    <div class="bg-white p-6 rounded-4xl shadow-sm border border-stone-100 flex flex-col md:flex-row justify-between items-center gap-4 hover:shadow-md transition-all">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-1">
                                <span class="font-black text-xl text-[#3C2A21]">#{{ $order->id }}</span>
                                <span class="px-3 py-0.5 rounded-full text-[8px] font-black uppercase border {{ $badgeColor }}">
                                    {{ str_replace('_', ' ', $status) }}
                                </span>
                            </div>
                            <h4 class="font-bold text-stone-800">{{ $order->nama_pembeli }}</h4>
                            <p class="text-[9px] text-accent-caramel font-bold uppercase tracking-widest mt-1">
                                {{ $order->metode_pembayaran }} • {{ $order->created_at->format('d M, H:i') }}
                            </p>
                        </div>
                        <div class="px-6 border-x border-stone-50 text-center">
                            <p class="font-black text-[#3C2A21] text-xl">Rp{{ number_format($order->total_harga) }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <form action="{{ route('orders.status', $order->id) }}" method="POST">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="text-[9px] font-black uppercase tracking-widest border border-stone-200 rounded-xl px-4 py-2 bg-stone-50 outline-none cursor-pointer">
                                    <option value="diproses" {{ $status === 'diproses' ? 'selected' : '' }}>Process</option>
                                    <option value="siap" {{ $status === 'siap' ? 'selected' : '' }}>Ready</option>
                                    <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Done</option>
                                </select>
                            </form>
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 text-red-400 rounded-xl hover:bg-red-500 hover:text-white transition-all text-sm">🗑️</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-10 rounded-4xl text-center text-stone-400 font-bold">Belum ada pesanan masuk.</div>
                @endforelse
            </div>
        </div>

        <hr class="border-stone-200 mb-12">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <div>
                <h2 class="text-sm font-black mb-4 flex items-center text-[#3C2A21] uppercase tracking-[0.2em]">
                    🕒 Arus Penjualan Per Jam
                </h2>
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-stone-100">
                    <div class="h-64"><canvas id="hourlyChart"></canvas></div>
                </div>
            </div>

            <div>
                <h2 class="text-sm font-black mb-4 flex items-center text-[#3C2A21] uppercase tracking-[0.2em]">
                    📈 Tren Penjualan Bulanan
                </h2>
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-stone-100">
                    <div class="h-64"><canvas id="monthlyChart"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // SETINGAN GLOBAL UNTUK SEMUA KURVA
        const globalOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false } 
            },
            scales: {
                y: { 
                    display: false, 
                    beginAtZero: true 
                },
                x: { 
                    grid: { display: false }, 
                    ticks: { 
                        color: '#3C2A21', 
                        font: { 
                            family: "'Plus Jakarta Sans', sans-serif", // Samakan font
                            size: 10, 
                            weight: 'bold' 
                        } 
                    } 
                }
            }
        };

        // 1. GRAFIK HARIAN (ARUS PENJUALAN PER JAM)
        const ctxH = document.getElementById('hourlyChart').getContext('2d');
        new Chart(ctxH, {
            type: 'line',
            data: {
                labels: JSON.parse('{!! json_encode($hourlyData->pluck("jam")) !!}').map(j => j + ':00'),
                datasets: [{
                    data: JSON.parse('{!! json_encode($hourlyData->pluck("total")) !!}'),
                    borderColor: '#3C2A21', // Cokelat Tua Sidebar
                    backgroundColor: 'rgba(60, 42, 33, 0.05)',
                    borderWidth: 4, // Tebal agar tegas
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#A06040'
                }]
            },
            options: globalOptions
        });

        // 2. GRAFIK BULANAN (TREN PENJUALAN)
        const ctxM = document.getElementById('monthlyChart').getContext('2d');
        new Chart(ctxM, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    data: JSON.parse('{!! json_encode($monthlyData->pluck("total")) !!}'),
                    borderColor: '#3C2A21', // Samakan warna dengan grafik harian
                    backgroundColor: 'rgba(60, 42, 33, 0.05)',
                    borderWidth: 4,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#A06040'
                }]
            },
            options: globalOptions
        });
    });
</script>
</body>
</html>