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
        
        /* Glassmorphism Effect */
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
            <h1 class="text-xl font-black tracking-widest uppercase">Valeria<span class="text-caramel">Admin</span></h1>
            <p class="text-[9px] opacity-40 tracking-[0.4em] mt-1 font-bold">EST. 2024</p>
        </div>

        <nav class="flex-1 px-4 space-y-1">
            <p class="px-4 text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-2">Main Menu</p>
            
            <a href="#" class="flex items-center px-4 py-3 rounded-xl bg-caramel text-white font-bold transition shadow-lg shadow-caramel/20">
                <span class="w-8">📊</span> Overview
            </a>
            <a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition group">
                <span class="w-8 group-hover:scale-125 transition">📝</span> Data Pesanan
                <span class="ml-auto bg-red-500 text-[10px] px-2 py-0.5 rounded-full animate-pulse">!</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 rounded-xl hover:bg-white/5 text-white/70 transition">
                <span class="w-8">⏳</span> Status Pesanan
            </a>
        </nav>

        <div class="p-6">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="w-full py-3 rounded-xl bg-white/5 hover:bg-red-500/20 text-white/50 hover:text-red-400 transition font-bold text-xs uppercase tracking-widest flex items-center justify-center gap-2">
                    Logout <span>🚪</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 lg:p-12 overflow-x-hidden">
        
        <header class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-4xl font-black text-[#2D2018] tracking-tighter uppercase italic">Overview</h2>
                <p class="text-stone-400 text-sm font-medium">Selamat datang kembali, Master Brewer! 👋</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-black text-stone-400 uppercase tracking-widest">{{ now()->format('l, d F Y') }}</p>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="glass-card p-6 rounded-3xl shadow-sm border-b-4 border-caramel">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-caramel/10 rounded-2xl text-caramel">📦</div>
                    <span class="text-[10px] font-black text-green-500 bg-green-50 px-2 py-1 rounded-lg">+12%</span>
                </div>
                <p class="text-xs font-bold text-stone-400 uppercase tracking-widest">Total Sales</p>
                <h3 class="text-4xl font-black text-[#2D2018] mt-1">{{ count($ordersToday ?? []) }}</h3>
            </div>

            <div class="glass-card p-6 rounded-3xl shadow-sm border-b-4 border-[#2D2018]">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-stone-100 rounded-2xl text-stone-600">💰</div>
                </div>
                <p class="text-xs font-bold text-stone-400 uppercase tracking-widest">Earnings</p>
                <h3 class="text-3xl font-black text-[#2D2018] mt-2">Rp{{ number_format(($ordersToday ?? collect())->sum('total_bayar')) }}</h3>
            </div>

            <div class="bg-coffee-dark p-6 rounded-3xl shadow-xl border-b-4 border-caramel text-white">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-white/10 rounded-2xl text-caramel">👥</div>
                </div>
                <p class="text-xs font-bold text-white/40 uppercase tracking-widest">Customers Today</p>
                <h3 class="text-4xl font-black mt-1">{{ $orders->unique('nama_pemesan')->count() }}</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
            <div class="xl:col-span-2">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-black text-[#2D2018] uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-6 bg-caramel rounded-full"></span> 
                        Recent Orders
                    </h3>
                    <a href="#" class="text-[10px] font-black text-caramel hover:underline">LIHAT SEMUA →</a>
                </div>

                <div class="space-y-4 max-h-[600px] overflow-y-auto pr-4 custom-scrollbar">
                    @forelse($orders as $order)
                        @php
                            $status = strtolower($order->status);
                            $badgeStyle = match ($status) {
                                'diproses', 'process' => 'bg-blue-500/10 text-blue-600 border-blue-200',
                                'siap', 'ready'       => 'bg-amber-500/10 text-amber-600 border-amber-200',
                                'sukses', 'done'      => 'bg-green-500/10 text-green-600 border-green-200',
                                default               => 'bg-stone-100 text-stone-500 border-stone-200',
                            };
                            $phone = preg_replace('/[^0-9]/', '', $order->nomor_wa);
                        @endphp
                        <div class="group bg-white p-5 rounded-2xl border border-stone-100 hover:border-caramel/30 hover:shadow-xl hover:shadow-stone-200/50 transition-all flex items-center gap-6">
                            <div class="w-12 h-12 bg-stone-50 rounded-xl flex items-center justify-center font-black text-stone-400 group-hover:bg-caramel group-hover:text-white transition-colors">
                                #{{ $order->id }}
                            </div>
                            
                            <div class="flex-1">
                                <h4 class="font-bold text-[#2D2018] truncate w-40">{{ $order->nama_pemesan }}</h4>
                                <span class="text-[9px] font-black uppercase tracking-widest text-stone-400">{{ $order->created_at->diffForHumans() }}</span>
                            </div>

                            <div class="hidden md:block text-right">
                                <p class="text-[10px] font-black text-stone-300 uppercase tracking-widest">Total</p>
                                <p class="font-bold text-caramel italic">Rp{{ number_format($order->total_bayar) }}</p>
                            </div>

                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="text-[10px] font-black uppercase tracking-tighter border-0 bg-stone-50 rounded-lg px-3 py-2 outline-none cursor-pointer focus:ring-1 focus:ring-caramel">
                                        <option value="diproses" {{ $status == 'diproses' ? 'selected' : '' }}>Process</option>
                                        <option value="siap" {{ $status == 'siap' ? 'selected' : '' }}>Ready</option>
                                        <option value="sukses" {{ $status == 'sukses' ? 'selected' : '' }}>Done</option>
                                    </select>
                                </form>
                                <a href="https://wa.me/{{ $phone }}" target="_blank" class="p-2 bg-green-500 text-white rounded-lg hover:bg-green-600 shadow-lg shadow-green-500/20 transition-transform hover:scale-110">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 bg-white rounded-3xl border-2 border-dashed border-stone-100 italic text-stone-400">Belum ada pesanan... 🪵</div>
                    @endforelse
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <h3 class="font-black text-[#2D2018] uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-2 h-6 bg-[#2D2018] rounded-full"></span> 
                        Sales Flow
                    </h3>
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-stone-100">
                        <div class="h-48"><canvas id="hourlyChart"></canvas></div>
                    </div>
                </div>

                <div class="bg-caramel p-6 rounded-3xl shadow-xl text-white">
                    <h3 class="font-black uppercase tracking-widest text-[10px] mb-4 opacity-60">Monthly Trend</h3>
                    <div class="h-40"><canvas id="monthlyChart"></canvas></div>
                </div>
                
                <div class="bg-[#F2EAE5] p-4 rounded-2xl border border-caramel/20">
                    <p class="text-[10px] font-black text-caramel uppercase tracking-[0.2em] mb-1">💡 Tips Admin</p>
                    <p class="text-xs text-[#2D2018] font-medium leading-relaxed">Penjualan tertinggi biasanya ada di jam <b>15:00 - 17:00</b>. Pastikan stok biji kopi aman!</p>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // @ts-nocheck
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

        // Bungkus dengan kutip satu agar VS Code menganggap ini string saat di editor
        // Tapi saat dijalankan, PHP akan mencetak JSON aslinya
        const hLabels = JSON.parse('{!! json_encode($hourlyData->pluck("jam")->map(fn($j) => $j . ":00")) !!}');
        const hData = JSON.parse('{!! json_encode($hourlyData->pluck("total")) !!}');
        const mData = JSON.parse('{!! json_encode($monthlyData->pluck("total")) !!}');

        new Chart(document.getElementById('hourlyChart'), {
            type: 'line',
            data: {
                labels: hLabels, // Pakai variabel yang sudah didefinisikan di atas
                datasets: [{
                    data: hData,
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
                    data: mData, // Pakai variabel di atas
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