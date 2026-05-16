@extends('layouts.admin')

@section('content')
@php
    $currentSelectedMonth = request('month', now()->month);
    
    // Pastikan variabel ini ada agar tidak "Undefined variable $filteredData"
    $filteredData = $salesData->where('month', $currentSelectedMonth);
    
    $monthData = $filteredData->first();
    
    $totalIncome = $monthData ? $monthData->total : 0;
    $totalOrders = $monthData ? $monthData->total_orders : 0;
@endphp

<main class="p-8 lg:p-12 w-full bg-[#FDFCFB] min-h-screen">
    <!-- Header -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-4">
        <div>
            <span class="text-caramel font-bold tracking-widest uppercase text-sm">Dashboard Keuangan</span>
            <h2 class="text-5xl font-black text-[#2D2018] tracking-tighter uppercase italic">Laporan Penjualan</h2>
            <p class="text-stone-400 mt-1">Analisis pendapatan real-time Valeria Coffee.</p>
        </div>
        <div class="flex gap-3">
            <!-- Filter Bulan -->
            <select id="monthFilter" class="bg-white border border-stone-200 px-4 py-3 rounded-xl font-bold text-stone-600 outline-none focus:ring-2 focus:ring-caramel transition">
                @foreach(range(1, 12) as $m)
                    @php
                        $isDisabledMonth = in_array($m, [1, 2, 3]);
                    @endphp
                    <option 
                        value="{{ $m }}" 
                        {{ $currentSelectedMonth == $m ? 'selected' : '' }}
                        {{ $isDisabledMonth ? 'disabled style=color:#ccc' : '' }}
                    >
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        @if($isDisabledMonth) (No Data) @endif
                    </option>
                @endforeach
            </select>

            <!-- Filter Tahun (2027 DIHAPUS, 2025 DISABLED) -->
            <select class="bg-white border border-stone-200 px-4 py-3 rounded-xl font-bold text-stone-600 outline-none focus:ring-2 focus:ring-caramel transition">
                <option value="2026" selected>Tahun 2026</option>
                <option value="2025" disabled style="color: #ccc;">Tahun 2025 (No Data)</option>
            </select>

            <button onclick="window.print()" class="bg-[#2D2018] text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:bg-opacity-90 transition flex items-center gap-2">
                <span>Cetak</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
            </button>
        </div>
    </header>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-[1.5rem] border border-stone-100 shadow-sm transition hover:shadow-md">
            <p class="text-stone-400 text-sm font-bold uppercase tracking-tight">Total Pendapatan ({{ DateTime::createFromFormat('!m', $currentSelectedMonth)->format('F') }})</p>
            <h3 class="text-3xl font-black text-[#2D2018] mt-1 italic">Rp{{ number_format($totalIncome, 0, ',', '.') }}</h3>
        </div>

    <!-- Card Jumlah Order (TAMBAHAN BARU) -->
        <div class="bg-white p-6 rounded-[1.5rem] border border-stone-100 shadow-sm border-l-4 border-l-caramel">
            <p class="text-stone-400 text-sm font-bold uppercase tracking-tight">Jumlah Order</p>
            <div class="flex items-baseline gap-2">
            <!-- Bagian Card Jumlah Order -->
            <h3 class="text-5xl font-black text-[#2D2018] italic leading-none tracking-tighter">
                {{$totalOrders}}
            </h3>
            <span class="text-stone-400 font-bold text-xs uppercase tracking-widest">Pesanan</span>
            </div>
        </div>

        <div class="bg-[#2D2018] p-6 rounded-[1.5rem] shadow-lg flex items-center justify-between">
            <div>
                <p class="text-stone-400 text-sm font-bold uppercase tracking-tight">Status Data</p>
                <h3 class="text-2xl font-black text-white mt-1 uppercase italic">
                    {{ $totalIncome > 0 ? 'Data Tersedia' : 'Kosong' }}
                </h3>
            </div>
            <div class="bg-caramel/20 p-3 rounded-full text-caramel">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Grafik Area -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Grafik Garis (Tren) -->
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-stone-100">
            <h3 class="font-black text-[#2D2018] uppercase mb-6 flex items-center gap-2">
                <span class="w-2 h-6 bg-caramel rounded-full"></span> Kurva Pendapatan 2026
            </h3>
            <div class="h-[300px]">
                <canvas id="monthlyLineChart"></canvas>
            </div>
        </div>

    <!-- Tabel -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-stone-100 overflow-hidden">
        <div class="p-6 border-b border-stone-50">
            <h3 class="font-black text-[#2D2018] uppercase tracking-tight">Rincian Penjualan: {{ DateTime::createFromFormat('!m', $currentSelectedMonth)->format('F') }}</h3>
        </div>
        <table class="w-full text-left border-collapse">
            <thead class="bg-stone-50/50">
                <tr>
                    <th class="p-6 text-xs font-black uppercase tracking-widest text-stone-400">Bulan</th>
                    <th class="p-6 text-xs font-black uppercase tracking-widest text-stone-400 text-right">Total Pendapatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-50">
                @forelse($filteredData as $data)
                <tr class="hover:bg-stone-50/30 transition group">
                    <td class="p-6 font-bold text-[#2D2018] flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-caramel opacity-100 transition"></div>
                        {{ DateTime::createFromFormat('!m', $data->month)->format('F') }}
                    </td>
                    <td class="p-6 text-right font-black text-caramel group-hover:translate-x-[-4px] transition-transform origin-right">
                        <span class="text-stone-300 font-medium mr-1 text-sm">Rp</span>{{ number_format($data->total, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="p-10 text-center text-stone-400 font-bold italic">
                        Belum ada data penjualan masuk di bulan {{ DateTime::createFromFormat('!m', $currentSelectedMonth)->format('F') }}
                    </td>
                </tr>
                @endforelse
                <style>
                /* CSS Khusus Cetak/PDF */
                @media print {
                    /* 1. Sembunyikan elemen navigasi dari layouts.admin */
                    aside, nav, .sidebar, #sidebar, .no-print {
                        display: none !important;
                    }

                    /* 2. Paksa konten utama untuk memenuhi lebar kertas A4 */
                    main {
                        position: absolute !important;
                        left: 0 !important;
                        top: 0 !important;
                        width: 100% !important;
                        margin: 0 !important;
                        padding: 20px !important;
                        background: white !important;
                    }

                    /* 3. Sembunyikan tombol Filter dan tombol Cetak di hasil PDF */
                    header .flex.gap-3 {
                        display: none !important;
                    }
                }
            </style>
            </tbody>
        </table>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Logika Redirect Filter Bulan
    document.getElementById('monthFilter').addEventListener('change', function() {
        const url = new URL(window.location.href);
        url.searchParams.set('month', this.value);
        window.location.href = url.href;
    });

    // Persiapan Data Bulanan (Jan-Des)
    const monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const rawMonthlyData = {!! json_encode(($salesData ?? collect())->pluck('total', 'month')) !!};
    const finalMonthlyData = Array(12).fill(0).map((_, i) => rawMonthlyData[i + 1] || 0);

    // --- 1. GRAFIK GARIS (KIRI) ---
    const ctxLine = document.getElementById('monthlyLineChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Pendapatan',
                data: finalMonthlyData,
                borderColor: '#C68642',
                backgroundColor: 'rgba(198, 134, 66, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 4,
                pointBackgroundColor: '#2D2018'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
            }
        }
    });

    // --- 2. GRAFIK BATANG BULANAN (KANAN - PENGGANTI HARIAN) ---
    const ctxBar = document.getElementById('monthlyBarChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Total Pendapatan',
                data: finalMonthlyData,
                backgroundColor: '#2D2018',
                borderRadius: 8,
                hoverBackgroundColor: '#C68642'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' }
                },
                x: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
            }
        }
    });
</script>
@endsection