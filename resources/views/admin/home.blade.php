<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valeria Coffee - Admin Control Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        .bg-coffee-admin { background-color: #3C2A21; }
        .text-accent-caramel { color: #A06040; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; scroll-behavior: smooth; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #3C2A21; border-radius: 10px; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); }
    </style>
</head>
<body class="flex bg-[#FDFBF7] min-h-screen text-[#3C2A21]">

    <aside class="w-64 bg-coffee-admin text-[#FDFBF7] shrink-0 p-6 flex flex-col sticky top-0 h-screen shadow-2xl z-50">
        <div class="mb-10 text-center">
            <h1 class="text-2xl font-black tracking-tighter text-accent-caramel uppercase">Valeria<span class="text-white opacity-50">Admin</span></h1>
            <p class="text-[10px] opacity-50 uppercase tracking-[0.3em] font-bold">Coffee Control Center</p>
        </div>

        <nav class="flex flex-col gap-2">
            <a href="{{ route('ulasan.index') }}" class="flex items-center p-4 rounded-2xl opacity-60 hover:opacity-100 hover:bg-white/5 transition">
                <span class="mr-3 text-lg">🏠</span> Beranda
            </a>
    
            <a href="{{ route('ulasan.index') }}" class="flex items-center p-4 rounded-2xl opacity-60 hover:opacity-100 hover:bg-white/5 transition">
                <span class="mr-3 text-lg">📦</span> Data Pesanan
            </a>

            <a href="{{ route('ulasan.index') }}" class="flex items-center p-4 rounded-2xl opacity-60 hover:opacity-100 hover:bg-white/5 transition">
                <span class="mr-3 text-lg">📊</span> Kurva Penjualan
            </a>

            <a href="{{ route('ulasan.index') }}" class="flex items-center p-4 rounded-2xl opacity-60 hover:opacity-100 hover:bg-white/5 transition">
                <span class="mr-3 text-lg">⭐</span> Ulasan Pelanggan
            </a>
            <div class="pt-6 mt-6 border-t border-white/10">
                <a href="{{ url('/') }}" target="_blank" class="block px-4 py-2 opacity-50 hover:opacity-100 font-bold text-[10px] uppercase tracking-[0.2em] transition">← Ke Halaman Toko</a>
            </div>
        </nav>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto pt-4 border-t border-white/10">
            @csrf
            <button type="submit" class="w-full flex items-center p-4 rounded-2xl bg-red-500/10 hover:bg-red-600 text-red-400 hover:text-white transition font-black text-[10px] uppercase tracking-widest">
                <span class="mr-3">🚪</span> Logout Akun
            </button>
        </form>
    </aside>

    <main class="flex-1 p-8 lg:p-12 overflow-x-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
            <div class="bg-white p-8 rounded-[3rem] shadow-sm border-b-8 border-accent-caramel card-hover">
                <p class="text-[10px] text-stone-400 font-black uppercase tracking-[0.2em] mb-4">Orders Today</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-7xl font-black text-[#3C2A21] tracking-tighter">{{ $ordersToday->count() }}</h3>
                    <span class="text-stone-400 font-bold uppercase text-[10px]">Unit</span>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[3rem] shadow-sm border-b-8 border-[#3C2A21] card-hover">
                <p class="text-[10px] text-stone-400 font-black uppercase tracking-[0.2em] mb-4">Revenue Today</p>
                <h3 class="text-4xl font-black text-[#3C2A21] tracking-tighter break-all">
                    Rp{{ number_format($ordersToday->sum('total_harga'), 0, ',', '.') }}
                </h3>
            </div>

            <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-stone-100 flex flex-col card-hover">
                <p class="text-[10px] text-stone-400 font-black uppercase tracking-[0.2em] mb-6 text-center italic">📈 Kurva 7 Hari Terakhir</p>
                <div class="h-28">
                    <canvas id="dailyChart"></canvas>
                </div>
            </div>
        </div>

        <section id="tabel-pesanan" class="mb-20">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
                <h2 class="text-4xl font-black text-[#3C2A21] tracking-tighter uppercase italic">📦 Pesanan Terkini</h2>
                <div class="bg-[#3C2A21] px-8 py-3 rounded-full text-[11px] font-black text-white tracking-[0.3em] shadow-xl uppercase">
                    Total: {{ $orders->count() }} Pesanan
                </div>
            </div>

            <div class="space-y-6 max-h-175 overflow-y-auto pr-4 custom-scrollbar">
                @forelse($orders as $order)
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-stone-100 flex flex-col lg:flex-row justify-between items-center gap-8 hover:shadow-xl transition-all border-l-8 {{ $order->status === 'selesai' ? 'border-green-500' : 'border-accent-caramel' }}">
                        <div class="flex-1 w-full lg:w-auto">
                            <div class="flex items-center gap-4 mb-2">
                                <span class="font-black text-3xl text-[#3C2A21]">#{{ $order->id }}</span>
                                <span class="px-4 py-1 rounded-full text-[9px] font-black uppercase border 
                                    {{ $order->status === 'selesai' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-amber-50 text-amber-600 border-amber-100' }}">
                                    {{ $order->status ?? 'diproses' }}
                                </span>
                            </div>
                            <h4 class="font-bold text-stone-800 text-xl mb-2">{{ $order->nama_pembeli }}</h4>
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="text-[10px] bg-stone-100 text-stone-500 px-3 py-1 rounded-lg font-black uppercase tracking-widest">
                                    {{ $order->metode_pembayaran }}
                                </span>
                                <span class="text-[10px] text-accent-caramel font-bold uppercase tracking-widest">
                                    📅 {{ $order->created_at->format('d M Y') }} • 🕒 {{ $order->created_at->format('H:i') }} WIB
                                </span>
                            </div>
                        </div>

                        <div class="text-center lg:text-right">
                            <p class="text-[10px] text-stone-400 font-black uppercase tracking-widest mb-1">Total Bayar</p>
                            <p class="font-black text-[#3C2A21] text-4xl">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
                        </div>

                        <div class="flex items-center gap-4 w-full lg:w-auto">
                            <form action="{{ route('orders.status', $order->id) }}" method="POST" class="flex-1 lg:flex-none">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="w-full lg:w-auto text-[10px] font-black uppercase border-2 border-stone-100 rounded-2xl px-6 py-4 bg-stone-50 cursor-pointer focus:border-accent-caramel outline-none transition">
                                    <option value="diproses" {{ $order->status === 'diproses' ? 'selected' : '' }}>⏳ Proses</option>
                                    <option value="siap" {{ $order->status === 'siap' ? 'selected' : '' }}>✅ Siap</option>
                                    <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>☕ Selesai</option>
                                </select>
                            </form>

                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Hapus data pesanan ini?')" class="flex-none">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="p-5 bg-red-50 text-red-500 rounded-2xl hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-20 rounded-[3rem] text-center border-4 border-dashed border-stone-100">
                        <span class="text-6xl block mb-4">📭</span>
                        <p class="text-stone-400 font-bold italic">Belum ada pesanan masuk hari ini.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 border-t border-stone-200 pt-16">
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-stone-100">
                <h2 class="text-sm font-black mb-8 uppercase tracking-[0.3em] flex items-center">
                    <span class="mr-3">🕒</span> Penjualan Per Jam
                </h2>
                <div class="h-72"><canvas id="hourlyChart"></canvas></div>
            </div>
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-stone-100">
                <h2 class="text-sm font-black mb-8 uppercase tracking-[0.3em] flex items-center">
                    <span class="mr-3">📈</span> Tren Bulanan
                </h2>
                <div class="h-72"><canvas id="monthlyChart"></canvas></div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { display: false, beginAtZero: true },
                    x: { grid: { display: false }, ticks: { color: '#3C2A21', font: { weight: 'bold', size: 10 } } }
                }
            };

            // Perbaikan diagnostik: Bungkus data Blade dalam tanda kutip untuk menipu parser JS di editor
            const hourlyLabels = JSON.parse('{!! json_encode($hourlyData->pluck("jam")->map(fn($j) => $j . ":00")) !!}');
            const hourlyValues = JSON.parse('{!! json_encode($hourlyData->pluck("total")) !!}');
            const monthlyValues = JSON.parse('{!! json_encode($monthlyData->pluck("total")) !!}');

            new Chart(document.getElementById('dailyChart'), {
                type: 'line',
                data: {
                    labels: ['S', 'S', 'R', 'K', 'J', 'S', 'M'],
                    datasets: [{
                        data: [5, 12, 8, 15, 25, 40, 35],
                        borderColor: '#A06040',
                        borderWidth: 4,
                        fill: true,
                        backgroundColor: 'rgba(160, 96, 64, 0.08)',
                        tension: 0.5,
                        pointRadius: 0
                    }]
                },
                options: commonOptions
            });

            new Chart(document.getElementById('hourlyChart'), {
                type: 'line',
                data: {
                    labels: hourlyLabels,
                    datasets: [{
                        data: hourlyValues,
                        borderColor: '#3C2A21',
                        borderWidth: 5,
                        fill: true,
                        backgroundColor: 'rgba(60, 42, 33, 0.05)',
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#3C2A21'
                    }]
                },
                options: commonOptions
            });

            new Chart(document.getElementById('monthlyChart'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        data: monthlyValues,
                        borderColor: '#A06040',
                        borderWidth: 5,
                        fill: true,
                        backgroundColor: 'rgba(160, 96, 64, 0.05)',
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#A06040'
                    }]
                },
                options: commonOptions
            });
        });
    </script>
</body>
</html>