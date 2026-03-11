<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Palet Warna Kopi */
        .bg-coffee-admin { background-color: #3C2A21; } /* Espresso Dark */
        .text-accent-caramel { color: #A06040; }       /* Caramel */
        html { scroll-behavior: smooth; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="flex bg-[#FDFBF7] min-h-screen text-[#3C2A21]">

    <div class="w-64 bg-coffee-admin text-[#FDFBF7] shrink-0 p-6 flex flex-col sticky top-0 h-screen shadow-2xl">
        <h1 class="text-2xl font-black tracking-tighter text-accent-caramel uppercase">Valeria<span class="text-white opacity-50">Admin</span></h1>
        <p class="text-[10px] opacity-50 mb-8 uppercase tracking-[0.3em] font-bold">Coffee Control Center</p>
        
        <nav class="flex-1 space-y-2 text-sm">
            <p class="text-[10px] uppercase font-bold opacity-30 mb-2 tracking-widest">Manajemen</p>
            
            <a href="{{ route('admin.orders') }}" class="flex items-center p-3 rounded-xl hover:bg-white/10 transition {{ request()->is('admin/orders') ? 'bg-white/10 border-l-4 border-accent-caramel font-bold' : '' }}">
                <span class="mr-3">☕</span> Daftar Pesanan
            </a>

            <a href="#stats-section" class="flex items-center p-3 rounded-xl hover:bg-white/10 transition">
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
            
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin keluar?')">
                @csrf
                <button type="submit" class="w-full flex items-center p-3 rounded-xl bg-red-500/10 hover:bg-red-600 text-red-400 hover:text-white transition font-bold text-[10px] uppercase tracking-widest">
                    <span class="mr-3">🚪</span> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="flex-1 p-10">
        <div id="stats-section" class="mb-12">
            <h2 class="text-xl font-black mb-6 flex items-center text-[#3C2A21] uppercase tracking-widest">
                <span class="mr-3">📊</span> Penjualan Hari Ini
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border-b-4 border-accent-caramel hover:shadow-md transition">
                    <p class="text-[10px] text-stone-400 font-black uppercase tracking-[0.2em]">Total Orders</p>
                    <h3 class="text-6xl font-black text-[#3C2A21] mt-2">{{ count($orders) }}</h3>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-sm border-b-4 border-[#3C2A21] hover:shadow-md transition">
                    <p class="text-[10px] text-stone-400 font-black uppercase tracking-[0.2em]">Revenue (IDR)</p>
                    <h3 class="text-6xl font-black text-[#3C2A21] mt-2">{{ number_format($orders->sum('total_harga')) }}</h3>
                </div>
            </div>
        </div>

        <hr class="mb-12 border-stone-200">

        <div id="list-section">
            <div class="flex justify-between items-center mb-10">
                <h2 class="text-3xl font-black text-[#3C2A21] tracking-tighter uppercase">📦 Daftar Transaksi</h2>
                <div class="bg-[#3C2A21] px-5 py-2 rounded-full text-[10px] font-bold text-white tracking-widest shadow-lg">
                    {{ now()->translatedFormat('d F Y') }}
                </div>
            </div>

            @if(session('success'))
                <div class="bg-accent-caramel text-white p-5 rounded-2xl mb-8 shadow-xl font-bold flex items-center gap-3">
                    <span>✨</span> {{ session('success') }}
                </div>
            @endif

            @if($orders->isEmpty())
                <div class="bg-white p-20 rounded-[3rem] shadow-inner border-2 border-dashed border-stone-200 text-center">
                    <p class="text-5xl mb-4 grayscale">☕</p>
                    <p class="font-bold text-stone-400">Belum ada pesanan yang masuk.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-5">
                    @foreach($orders as $order)
                        @php
                            $status = $order->status ?? 'diproses';
                            $badgeColor = match ($status) {
                                'diproses' => 'bg-blue-50 text-blue-600 border-blue-100',
                                'siap' => 'bg-amber-50 text-amber-600 border-amber-100',
                                'selesai' => 'bg-green-50 text-green-600 border-green-100',
                                'menunggu_pembayaran' => 'bg-red-50 text-red-600 border-red-100',
                                default => 'bg-stone-50 text-stone-600 border-stone-100',
                            };
                        @endphp

                        <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-stone-100 flex flex-col md:flex-row justify-between items-center gap-6 hover:shadow-lg transition-all duration-300">
                            <div class="flex-1">
                                <div class="flex items-center gap-4 mb-2">
                                    <span class="font-black text-2xl text-[#3C2A21]">#{{ $order->id }}</span>
                                    <span class="px-4 py-1 rounded-full text-[9px] font-black uppercase border-2 {{ $badgeColor }}">
                                        {{ str_replace('_', ' ', $status) }}
                                    </span>
                                </div>
                                <h4 class="font-bold text-stone-800 text-xl leading-tight">{{ $order->nama_pembeli }}</h4>
                                <p class="text-[10px] text-accent-caramel font-black uppercase tracking-widest mt-1">
                                    {{ $order->metode_pembayaran }} • Meja {{ $order->nomor_meja ?? '-' }}
                                </p>
                            </div>

                            <div class="px-8 border-x border-stone-100 text-center">
                                <p class="text-[9px] text-stone-400 font-black uppercase tracking-widest mb-1">Bill Amount</p>
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

                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Hapus data?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-3 bg-red-50 text-red-500 rounded-2xl hover:bg-red-500 hover:text-white transition-all border border-red-100">
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