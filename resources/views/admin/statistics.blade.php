<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Harian - Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-coffee-admin { background-color: #3C2A21; }
        .text-accent-caramel { color: #A06040; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="flex bg-[#FDFBF7] min-h-screen text-[#3C2A21]">

    <div class="w-64 bg-coffee-admin text-[#FDFBF7] shrink-0 p-6 flex flex-col sticky top-0 h-screen shadow-2xl">
        <h1 class="text-2xl font-black tracking-tighter text-accent-caramel uppercase">Valeria<span class="text-white opacity-50">Admin</span></h1>
        <p class="text-[10px] opacity-50 mb-8 uppercase tracking-[0.3em] font-bold">Coffee Control Center</p>
        
        <nav class="flex-1 space-y-2 text-sm">
            <p class="text-[10px] uppercase font-bold opacity-30 mb-2 tracking-widest">Manajemen</p>
            
            <a href="{{ route('admin.orders') }}" class="flex items-center p-3 rounded-xl hover:bg-white/10 transition opacity-60 hover:opacity-100">
                <span class="mr-3">☕</span> Daftar Pesanan
            </a>

            <a href="{{ route('admin.stats') }}" class="flex items-center p-3 rounded-xl bg-white/10 border-l-4 border-accent-caramel font-bold transition">
                <span class="mr-3">📈</span> Statistik Harian
            </a>

            <div class="pt-4 mt-4 border-t border-white/5">
                <a href="{{ route('home') }}" class="block py-2 opacity-50 hover:opacity-100 font-bold text-xs uppercase tracking-widest transition">
                    ← Lihat Toko
                </a>
            </div>
        </nav>

        <div class="mt-auto pt-4 border-t border-white/5">
            <div class="flex items-center gap-3 mb-4 px-2">
                <div class="w-8 h-8 rounded-full bg-accent-caramel/20 flex items-center justify-center font-bold text-xs text-accent-caramel">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-bold truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                    <p class="text-[9px] opacity-40 truncate">Admin Level</p>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center p-3 rounded-xl bg-red-500/10 hover:bg-red-600 text-red-400 hover:text-white transition font-bold text-[10px] uppercase tracking-widest">
                    <span class="mr-3">🚪</span> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="flex-1 p-10">
        
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-3xl font-black text-[#3C2A21] tracking-tighter uppercase">📈 Penjualan Harian</h2>
            <div class="bg-white border border-stone-200 px-6 py-2 rounded-full text-[10px] font-bold text-stone-500 tracking-[0.2em] shadow-sm uppercase">
                Hari Ini: {{ now()->translatedFormat('d F Y') }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border-b-8 border-accent-caramel hover:shadow-xl transition-all duration-500">
                <p class="text-[10px] text-stone-400 font-black uppercase tracking-[0.2em] mb-2">Orders Today</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-7xl font-black text-[#3C2A21]">{{ count($ordersToday) }}</h3>
                    <span class="text-stone-400 font-bold uppercase text-xs">Pesanan</span>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border-b-8 border-[#3C2A21] hover:shadow-xl transition-all duration-500">
                <p class="text-[10px] text-stone-400 font-black uppercase tracking-[0.2em] mb-2">Revenue Today</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-6xl font-black text-[#3C2A21]">Rp{{ number_format($ordersToday->sum('total_harga')) }}</h3>
                </div>
            </div>
        </div>

        <div class="mb-12">
            <h2 class="text-xl font-black mb-6 flex items-center text-[#3C2A21] uppercase tracking-widest">
                <span class="mr-3">🕒</span> Arus Penjualan Per Jam
            </h2>
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-stone-100">
                <div class="h-80 w-full">
                    <canvas id="hourlyChart"></canvas>
                </div>
                <div class="mt-8 pt-6 border-t border-stone-100 text-center">
                    <p class="text-[10px] text-stone-300 font-bold uppercase tracking-[0.3em]">Data diambil secara real-time dari MySQL</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctxH = document.getElementById('hourlyChart').getContext('2d');
            
            // Konversi data dari Laravel ke JS Array dengan aman
            const labels = JSON.parse('{!! json_encode($hourlyData->pluck("jam")) !!}').map(j => j + ':00');
            const dataValues = JSON.parse('{!! json_encode($hourlyData->pluck("total")) !!}');

            new Chart(ctxH, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        data: dataValues,
                        borderColor: '#3C2A21',
                        backgroundColor: 'rgba(60, 42, 33, 0.05)',
                        borderWidth: 4,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#A06040',
                        pointRadius: 4,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            display: false, // Menghilangkan angka di kiri sesuai permintaan
                            beginAtZero: true
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: '#3C2A21',
                                font: { weight: 'bold', size: 10 }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>