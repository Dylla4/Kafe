<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valeria Coffee - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F7F4; }
        .bg-coffee-dark { background-color: #2D2018; }
        .text-caramel { color: #C68B59; }
        .border-caramel { border-color: #C68B59; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #C68B59; border-radius: 10px; }
    </style>
</head>
<body class="flex min-h-screen">

<aside class="w-72 bg-coffee-dark text-white flex flex-col sticky top-0 h-screen z-50">
    <div class="p-8 text-center">
        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/20">
            <span class="text-3xl">☕</span>
        </div>
        <h1 class="text-xl font-black tracking-widest uppercase">Valeria<span class="text-caramel">Coffee</span></h1>
        <p class="text-[9px] opacity-40 tracking-[0.4em] mt-1 font-bold">Dashboard ADMIN</p>
    </div>
    <nav class="flex-1 px-4 space-y-1 overflow-y-auto custom-scrollbar">
        <p class="px-4 text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-2">Main Menu</p>
        
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl bg-caramel text-white font-bold transition shadow-lg shadow-caramel/20">
            <span class="w-8">📊</span> Overview
        </a>

        <a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition group">
            <span class="w-8 group-hover:scale-125 transition">📝</span> Data Pesanan
            <span class="ml-auto bg-red-500 text-[10px] px-2 py-0.5 rounded-full animate-pulse italic">!</span>
        </a>

        <a href="{{ route('admin.reviews') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition group">
            <span class="w-8 group-hover:scale-125 transition">⭐</span> Reviews Pesanan
        </a>

        <a href="{{ route('admin.report') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition group">
            <span class="w-8 group-hover:scale-125 transition">📈</span> Laporan Penjualan
        </a>

    </nav>

    <div class="p-6 border-t border-white/5 mt-auto">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full py-3 rounded-xl bg-white/5 hover:bg-red-500/20 text-white/50 hover:text-red-400 transition font-bold">
                Logout <span>🚪</span>
            </button>
        </form>
    </div>
</aside>

<main class="flex-1 p-8 lg:p-12 overflow-x-hidden w-full">
    
    <header class="flex justify-between items-end mb-10 w-full">
        <div>
            <h2 class="text-5xl font-black text-[#2D2018] tracking-tighter uppercase italic leading-none">Overview</h2>
            <span class="text-caramel font-bold tracking-widest uppercase text-sm">Selamat datang kembali 👋</span>
        </div>
        <div class="text-right">
            <p class="text-xs font-black text-stone-400 uppercase tracking-widest">{{ now()->format('l, d F Y') }}</p>
        </div>
    </header>

    <!-- Laporan -->
    <div class="w-full mt-10">
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('admin.report') }}" class="group flex items-center gap-3 no-underline">
                <span class="w-2 h-8 bg-stone-200 rounded-full group-hover:bg-caramel transition-all"></span>
                <h3 class="text-2xl font-black text-[#2D2018] uppercase tracking-tighter group-hover:text-caramel transition-all">
                    Tren Penjualan
                </h3>
            </a>
        </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10 w-full">
        <!-- Card 1: Total Order -->
        <div class="glass-card p-8 rounded-[2rem] shadow-sm border-b-4 border-caramel">
            <p class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-1">Pesanan Masuk Hari Ini</p>
            <h3 class="text-5xl font-black text-[#2D2018]">
                {{ count($ordersToday ?? []) }}
            </h3>
        </div>

        <!-- Card 2: Total Earnings -->
        <div class="glass-card p-8 rounded-[2rem] shadow-sm border-b-4 border-[#2D2018]">
            <p class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-1">Pendapatan Hari Ini</p>
            <h3 class="text-4xl font-black text-[#2D2018]">
                Rp{{ number_format(($ordersToday ?? collect())->sum('total_bayar'), 0, ',', '.') }}
            </h3>
        </div>

        <!-- Card 3: Customers (Fix error image_018aba.png) -->
        <div class="bg-coffee-dark p-8 rounded-[2rem] shadow-xl border-b-4 border-caramel text-white">
            <p class="text-xs font-bold text-white/40 uppercase tracking-widest mb-1">Jumlah Pelanggan Hari Ini</p>
            <h3 class="text-5xl font-black">
                {{ ($orders ?? collect())->unique('nama_pemesan')->count() }}
            </h3>
        </div>
    </div>



        <!-- Bagian Grafik -->
        <div class="space-y-8 mb-12 w-full">
            <!-- Chart 1: Kurva Harian (Dibuat Full Width) -->
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-stone-100 min-h-[450px] flex flex-col w-full">
                <h3 class="font-black text-[#2D2018] text-sm uppercase tracking-widest mb-8 flex items-center gap-3">
                    <span class="w-2 h-8 bg-caramel rounded-full"></span> Kurva Harian
                </h3>
                <div class="flex-1 w-full h-[350px]">
                    <canvas id="hourlyChart"></canvas>
                </div>
    </div>

    <!-- Recent Orders -->
    <div class="w-full mt-10">
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('admin.orders') }}" class="group flex items-center gap-3 no-underline">
                <span class="w-2 h-8 bg-stone-200 rounded-full group-hover:bg-caramel transition-all"></span>
                <h3 class="text-2xl font-black text-[#2D2018] uppercase tracking-tighter group-hover:text-caramel transition-all">
                    Data Pesanan
                </h3>
            </a>
        </div>

        <div class="grid grid-cols-1 gap-4">
            @forelse(($orders ?? collect())->take(5) as $order)
                <div class="bg-white p-6 rounded-[2rem] border border-stone-100 flex items-center justify-between group hover:shadow-md transition">
                    <div class="flex items-center gap-6">
                        <div class="w-14 h-14 bg-stone-50 rounded-2xl flex items-center justify-center font-black text-[#2D2018]">
                            #{{ $order->id }}
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-[#2D2018]">{{ $order->nama_pemesan }}</h4>
                            <p class="text-[10px] uppercase text-stone-400 font-bold tracking-widest">
                                {{ $order->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] uppercase text-stone-400 font-black mb-1">Total Harga</p>
                        <p class="text-xl font-black text-caramel italic">
                            Rp{{ number_format($order->total_bayar, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 bg-white rounded-3xl border-2 border-dashed italic text-stone-400">
                    Belum ada pesanan masuk...
                </div>

    <!-- Reviuw -->
    <div class="w-full mt-10">
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('admin.reviews') }}" class="group flex items-center gap-3 no-underline">
                <span class="w-2 h-8 bg-stone-200 rounded-full group-hover:bg-caramel transition-all"></span>
                <h3 class="text-2xl font-black text-[#2D2018] uppercase tracking-tighter group-hover:text-caramel transition-all">
                    Reviews Pesanan
                </h3>
            </a>
        </div>
            @endforelse
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Logic Chart Harian
    const ctxHourly = document.getElementById('hourlyChart').getContext('2d');
    new Chart(ctxHourly, {
        type: 'line',
        data: {
            labels: ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00'],
            datasets: [{
                label: 'Pesanan',
                data: [5, 12, 15, 8, 20, 15, 25],
                borderColor: '#C68B59',
                backgroundColor: 'rgba(198, 139, 89, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });
</script>

</body>
</html>