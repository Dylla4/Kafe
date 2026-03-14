<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan - Valeria Coffee</title>
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
            
            <a href="{{ route('admin.orders') }}" class="flex items-center p-3 rounded-xl bg-white/10 border-l-4 border-accent-caramel font-bold transition">
                <span class="mr-3">☕</span> Daftar Pesanan
            </a>

            <a href="{{ route('admin.stats') }}" class="flex items-center p-3 rounded-xl hover:bg-white/10 transition opacity-60 hover:opacity-100">
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
        
        <div id="list-section" class="mb-16">
            <div class="flex justify-between items-center mb-10">
                <h2 class="text-3xl font-black text-[#3C2A21] tracking-tighter uppercase">📦 Riwayat Semua Order</h2>
                <div class="bg-[#3C2A21] px-6 py-2 rounded-full text-[10px] font-bold text-white tracking-[0.2em] shadow-lg">
                    TOTAL DATA: {{ $orders->count() }}
                </div>
            </div>

            @if(session('success'))
                <div class="bg-accent-caramel text-white p-5 rounded-2xl mb-8 shadow-xl font-bold flex items-center gap-3">
                    <span>✨</span> {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-5">
                @forelse($orders as $order)
                    @php
                        $status = $order->status ?? 'diproses';
                        $badgeColor = match ($status) {
                            'diproses' => 'bg-blue-50 text-blue-600 border-blue-100',
                            'siap' => 'bg-amber-50 text-amber-600 border-amber-100',
                            'selesai' => 'bg-green-50 text-green-600 border-green-200',
                            'menunggu_pembayaran' => 'bg-red-50 text-red-600 border-red-100',
                            default => 'bg-stone-50 text-stone-600 border-stone-100',
                        };
                    @endphp

                    <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-stone-100 flex flex-col md:flex-row justify-between items-center gap-6 hover:shadow-xl transition-all duration-300">
                        <div class="flex-1">
                            <div class="flex items-center gap-4 mb-2">
                                <span class="font-black text-2xl text-[#3C2A21]">#{{ $order->id }}</span>
                                <span class="px-4 py-1 rounded-full text-[9px] font-black uppercase border-2 {{ $badgeColor }}">
                                    {{ str_replace('_', ' ', $status) }}
                                </span>
                            </div>
                            <h4 class="font-bold text-stone-800 text-xl leading-tight">{{ $order->nama_pembeli }}</h4>
                            <p class="text-[10px] text-accent-caramel font-black uppercase tracking-widest mt-1">
                                {{ $order->metode_pembayaran }} • {{ $order->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>

                        <div class="px-8 border-x border-stone-100 text-center">
                            <p class="text-[9px] text-stone-400 font-bold uppercase tracking-widest mb-1">Bill Total</p>
                            <p class="font-black text-[#3C2A21] text-2xl">Rp{{ number_format($order->total_harga) }}</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <form action="{{ route('orders.status', $order->id) }}" method="POST">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="text-[10px] font-black uppercase tracking-widest border-2 border-stone-100 rounded-2xl px-5 py-3 bg-stone-50 focus:border-accent-caramel outline-none transition cursor-pointer">
                                    <option value="menunggu_pembayaran" {{ $status === 'menunggu_pembayaran' ? 'selected' : '' }}>Pending</option>
                                    <option value="diproses" {{ $status === 'diproses' ? 'selected' : '' }}>Process</option>
                                    <option value="siap" {{ $status === 'siap' ? 'selected' : '' }}>Ready</option>
                                    <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Done</option>
                                </select>
                            </form>

                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Hapus permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-3 bg-red-50 text-red-500 rounded-2xl hover:bg-red-500 hover:text-white transition-all border border-red-100">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-20 rounded-[3rem] shadow-inner border-2 border-dashed border-stone-200 text-center">
                        <p class="text-5xl mb-4 grayscale">☕</p>
                        <p class="font-bold text-stone-400 text-xl">Database pesanan masih kosong.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mb-12">
            <h2 class="text-xl font-black mb-6 flex items-center text-[#3C2A21] uppercase tracking-widest">
                <span class="mr-3">📈</span> Tren Penjualan Bulanan
            </h2>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-stone-100">
                <div class="h-64">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('monthlyChart').getContext('2d');
        
        // Menggunakan JSON.parse agar VS Code tidak lapor error "Decorator"
        const monthlyValues = JSON.parse('{!! json_encode($monthlyData->pluck("total")) !!}');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pendapatan',
                    data: monthlyValues,
                    borderColor: '#A06040',
                    backgroundColor: 'rgba(160, 96, 64, 0.1)',
                    borderWidth: 4,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3C2A21',
                    pointRadius: 5,
                    pointHoverRadius: 8
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
                    // MENYEMBUNYIKAN ANGKA DI SEBELAH KIRI (Y-AXIS)
                    y: {
                        display: false,
                        beginAtZero: true
                    },
                    // MENYEMBUNYIKAN GARIS GRID (LATAR BELAKANG)
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#3C2A21',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>