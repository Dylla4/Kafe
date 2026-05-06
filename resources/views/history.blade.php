<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .order-card { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .order-card:hover { 
            transform: translateY(-6px);
            box-shadow: 0 20px 40px -15px rgba(60, 42, 33, 0.1);
        }
        .coffee-gradient {
            background: linear-gradient(135deg, #3C2A21 0%, #1A120B 100%);
        }
    </style>
</head>
<body class="bg-[#F9F8F6] text-stone-800 p-6 md:p-12">

<div class="max-w-4xl mx-auto">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row items-center justify-between mb-12 pb-8 border-b-2 border-stone-100">
        <div class="flex items-center gap-6 text-center md:text-left flex-col md:flex-row">
            <div class="w-16 h-16 rounded-2xl coffee-gradient flex items-center justify-center shadow-2xl rotate-3">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-4xl font-extrabold text-[#3C2A21] tracking-tighter uppercase mb-1">Riwayat Pesanan</h1>
                <p class="text-stone-400 text-sm font-semibold tracking-wide uppercase">Track your caffeine journey</p>
            </div>
        </div>
        <a href="{{ url('/') }}" class="mt-6 md:mt-0 flex items-center gap-2 px-6 py-3 bg-white border border-stone-200 rounded-full text-[10px] font-black uppercase tracking-[0.2em] text-stone-500 hover:text-orange-800 hover:border-orange-200 transition-all shadow-sm">
            <span>← Kembali Ke Home</span>
        </a>
    </div>

    <div class="space-y-8">
        @forelse($orders as $order)
            <div class="order-card bg-white p-8 rounded-[3rem] border border-stone-50 flex flex-col md:flex-row justify-between items-center gap-8 relative overflow-hidden group">
                {{-- Decorative Element --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-stone-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>

                {{-- Info Pesanan --}}
                <div class="flex-1 w-full md:w-auto relative">
                    <div class="flex flex-wrap items-center gap-3 mb-5">
                        <span class="text-[10px] font-black uppercase tracking-widest text-white bg-[#A06040] px-4 py-1.5 rounded-full shadow-lg shadow-orange-100">
                            #VAL-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                        
                        {{-- Status Badge --}}
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border
                            {{ strtolower($order->status) == 'selesai' || strtolower($order->status) == 'sukses' ? 'bg-green-50 text-green-600 border-green-100' : (strtolower($order->status) == 'dibatalkan' ? 'bg-red-50 text-red-600 border-red-100' : 'bg-orange-50 text-orange-600 border-orange-100') }}">
                            ● {{ $order->status }}
                        </span>
                    </div>

                    <h3 class="font-extrabold text-2xl text-[#3C2A21] mb-4 tracking-tight">{{ $order->nama_pemesan }}</h3>
                    
                    <div class="grid grid-cols-2 md:flex items-center gap-4 text-[10px] text-stone-400 font-bold uppercase tracking-[0.15em]">
                        <div class="flex items-center gap-2 bg-stone-50 px-3 py-2 rounded-xl">
                            <span class="opacity-60 text-lg leading-none">📅</span>
                            {{ $order->created_at->format('d M Y') }}
                        </div>
                        <div class="flex items-center gap-2 bg-orange-50/50 text-orange-800 px-3 py-2 rounded-xl">
                            <span class="opacity-60 text-lg leading-none">🥡</span>
                            {{ str_replace('_', ' ', $order->jenis_pesanan) }}
                        </div>
                        <div class="flex items-center gap-2 bg-stone-50 px-3 py-2 rounded-xl col-span-2 md:col-span-1">
                            <span class="opacity-60 text-lg leading-none">💳</span>
                            {{ $order->metode_pembayaran }}
                        </div>
                    </div>
                </div>

                {{-- Aksi & Harga --}}
                <div class="w-full md:w-auto flex md:flex-col justify-between items-center md:items-end gap-6 border-t md:border-t-0 pt-6 md:pt-0 relative">
                    <div class="text-left md:text-right">
                        <p class="text-[10px] text-stone-300 font-black uppercase tracking-widest mb-1">Total Transaksi</p>
                        <p class="text-3xl font-black text-[#3C2A21] leading-none">
                            <span class="text-sm font-bold text-[#A06040] align-top">Rp</span>{{ number_format($order->total_bayar, 0, ',', '.') }}
                        </p>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        @if(strtolower($order->status) == 'sukses' || strtolower($order->status) == 'selesai')
                            @if(!$order->review)
                                <a href="{{ route('ulasan.create', ['order_id' => $order->id]) }}" 
                                   class="px-8 py-3.5 bg-[#3C2A21] text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-black transition-all shadow-xl shadow-stone-200 active:scale-95">
                                    ⭐ Tulis Ulasan
                                </a>
                            @else
                                <div class="px-6 py-3 bg-green-50 text-green-700 rounded-2xl border border-green-100 flex items-center gap-2">
                                    <span class="text-[10px] font-black uppercase tracking-widest">Diulas</span>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                                </div>
                            @endif
                        @endif

                        <a href="{{ route('invoice.print', $order->id) }}" class="p-3.5 bg-stone-100 text-stone-500 rounded-2xl hover:bg-[#3C2A21] hover:text-white transition-all group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-32 bg-white rounded-[4rem] border border-stone-100 shadow-sm px-10">
                <div class="relative inline-block mb-10">
                    <div class="absolute -inset-4 bg-orange-100 rounded-full blur-2xl opacity-50 animate-pulse"></div>
                        <span class="relative text-8xl">☕</span>
                    </div>
                        <h3 class="text-3xl font-black text-[#3C2A21] uppercase tracking-tighter mb-4">Keranjang Masih Kosong</h3>
                        <p class="text-stone-400 mt-2 mb-10 text-sm max-w-sm mx-auto font-medium">Anda belum memulai cerita rasa bersama kami. Mari pesan Menu terbaik dari Valeria Coffee!</p>
                    {{-- Bagian tombol di dalam kondisi @empty --}}
                    <a href="{{ url('/menu') }}" class="bg-[#3C2A21] text-white px-14 py-5 rounded-full font-black uppercase tracking-[0.3em] text-[10px] hover:bg-black transition-all shadow-[0_20px_40px_rgba(0,0,0,0.1)] active:scale-95 inline-block">
                        Mulai Pesan
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Footer --}}
    <div class="mt-20 text-center">
        <div class="h-px bg-stone-200 w-24 mx-auto mb-8"></div>
        <p class="text-[9px] text-stone-300 font-black uppercase tracking-[0.5em]">&copy; 2026 VALERIA COFFEE</p>
    </div>
</div>

</body>
</html>