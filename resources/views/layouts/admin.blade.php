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

<body class="flex bg-[#FDFCFB] min-h-screen">

<aside class="w-72 bg-coffee-dark text-white flex flex-col sticky top-0 h-screen z-50">
    <div class="p-8 text-center">
        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/20">
            <span class="text-3xl">☕</span>
        </div>
        <h1 class="text-xl font-black tracking-widest uppercase">Valeria<span class="text-caramel">Admin</span></h1>
        <p class="text-[9px] opacity-40 tracking-[0.4em] mt-1 font-bold">EST. 2024</p>
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

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col overflow-hidden">
        @yield('content')
    </div>

</body>
</html>