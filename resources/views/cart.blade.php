<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; scroll-behavior: smooth; }
        .animate-fade-in { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-stone-50 text-stone-800 p-4 md:p-12">
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden border border-stone-100 animate-fade-in">
        
        {{-- Header Section --}}
        <div class="p-8 pb-0 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-stone-900 flex items-center">
                    <span class="mr-3 text-4xl">🛒</span> Keranjang <span class="text-orange-700 ml-2 italic">Saya</span>
                </h1>
                <p class="text-stone-400 text-sm mt-1">Selesaikan pesanan Valeria Coffee Anda</p>
            </div>
            <a href="{{ route('menu') }}" class="group inline-flex items-center px-6 py-3 bg-orange-50 text-orange-700 rounded-2xl font-bold text-sm hover:bg-orange-600 hover:text-white transition-all duration-300 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:rotate-90 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pesanan
            </a>
        </div>

        @if(!empty($cartItems) && count($cartItems) > 0)
            <div class="p-8">
                {{-- Table Section --}}
                <div class="overflow-x-auto mb-10">
                    <table class="w-full text-left">
                        <thead class="border-b border-stone-100 text-stone-400 uppercase text-[10px] font-black tracking-widest">
                            <tr>
                                <th class="pb-4">Menu</th>
                                <th class="pb-4 hidden md:table-cell">Harga</th>
                                <th class="pb-4 text-center">Qty</th>
                                <th class="pb-4 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-50">
                            @php $total = 0; @endphp
                            @foreach($cartItems as $id => $details)
                                @php $total += $details['harga'] * $details['quantity']; @endphp
                                <tr class="group">
                                    {{-- Kolom Menu --}}
                                    <td class="py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="w-16 h-16 shrink-0 bg-stone-100 rounded-2xl overflow-hidden border border-stone-100 group-hover:scale-105 transition-transform">
                                                @if(isset($details['foto']) && $details['foto'])
                                                    <img src="{{ asset($details['foto']) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-2xl bg-stone-50">☕</div>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="block font-bold text-stone-800 uppercase text-sm tracking-tight">{{ $details['nama_menu'] }}</span>
                                                <span class="text-xs text-orange-600 font-semibold md:hidden">Rp {{ number_format($details['harga'], 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom Harga (Desktop) --}}
                                    <td class="hidden md:table-cell text-stone-500 font-medium text-sm">
                                        Rp {{ number_format($details['harga'], 0, ',', '.') }}
                                    </td>

                                    {{-- Kolom Qty dengan Tombol --}}
                                    <td class="py-5 text-center">
                                        <div class="inline-flex items-center gap-3 bg-stone-50 p-2 rounded-2xl border border-stone-100">
                                            <button type="button" 
                                                    onclick="updateQuantity('{{ $id }}', 'decrease')" 
                                                    class="w-8 h-8 flex items-center justify-center rounded-xl bg-white border border-stone-200 text-stone-600 hover:bg-orange-50 hover:text-orange-700 hover:border-orange-200 transition-all shadow-sm active:scale-90 font-bold">
                                                -
                                            </button>
                                            <span class="font-black text-stone-800 text-sm min-w-5">
                                                {{ $details['quantity'] }}
                                            </span>
                                            <button type="button" 
                                                    onclick="updateQuantity('{{ $id }}', 'increase')" 
                                                    class="w-8 h-8 flex items-center justify-center rounded-xl bg-stone-900 text-white hover:bg-orange-700 transition-all shadow-md active:scale-90 font-bold">
                                                +
                                            </button>
                                        </div>
                                    </td>

                                    {{-- Kolom Subtotal --}}
                                    <td class="text-right font-bold text-stone-900">
                                        Rp {{ number_format($details['harga'] * $details['quantity'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Total Banner --}}
                <div class="bg-stone-900 rounded-3xl p-6 mb-10 flex justify-between items-center text-white shadow-lg">
                    <span class="text-xs font-black uppercase tracking-[0.3em] opacity-60">Total Keseluruhan</span>
                    <span class="text-3xl font-black">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                {{-- Form Section --}}
                <form id="form-pembayaran" class="bg-orange-50/50 p-8 rounded-3xl border border-orange-100 space-y-6">
                    @csrf
                    <h3 class="text-xs font-black text-orange-900 uppercase tracking-[0.2em] flex items-center mb-4">
                        <span class="bg-orange-200 p-1.5 rounded-lg mr-3">📋</span> Rincian Pengiriman & Waktu
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black text-orange-900/50 mb-2 uppercase tracking-widest">Nama Pemesan</label>
                            <input type="text" name="nama_pemesan" value="{{ auth()->user()->name ?? 'Pelanggan' }}" readonly class="w-full p-4 rounded-2xl border-none bg-white text-sm font-bold text-stone-400 cursor-not-allowed shadow-sm">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-orange-900 mb-2 uppercase tracking-widest">Tanggal Booking</label>
                            <input type="date" name="tanggal_booking" id="tanggal_booking" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+7 days')) }}" value="{{ date('Y-m-d') }}" class="w-full p-4 border border-stone-200 rounded-2xl text-sm bg-white shadow-sm outline-none focus:ring-2 focus:ring-orange-500 transition-all font-bold" required>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-orange-900 mb-2 uppercase tracking-widest">Jam Booking</label>
                            <select name="jam_booking" id="jam_booking" class="w-full p-4 border border-stone-200 rounded-2xl text-sm bg-white shadow-sm outline-none focus:ring-2 focus:ring-orange-500 transition-all font-bold cursor-pointer" required>
                                <option value="" disabled selected>Pilih Jam</option>
                                @for ($i = 9; $i <= 22; $i++)
                                    @php 
                                        $t1 = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                                        $t2 = str_pad($i, 2, '0', STR_PAD_LEFT) . ':30';
                                    @endphp
                                    <option value="{{ $t1 }}">{{ $t1 }}</option>
                                    @if($i < 22) <option value="{{ $t2 }}">{{ $t2 }}</option> @endif
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-orange-900 mb-2 uppercase tracking-widest">Metode Layanan</label>
                            <select name="jenis_pesanan" id="metode_layanan" onchange="toggleLayanan()" class="w-full p-4 border border-stone-200 rounded-2xl text-sm bg-white shadow-sm outline-none focus:ring-2 focus:ring-orange-500 font-bold cursor-pointer">
                                <option value="dine_in">🍽️ Makan di Tempat</option>
                                <option value="delivery">🚚 Delivery</option>
                                <option value="take_away">🥡 Take Away (Bawa Pulang)</option>
                            </select>
                        </div>

                        <div id="section-meja">
                            <label class="block text-[10px] font-black text-orange-900 mb-2 uppercase tracking-widest">Nomor Meja</label>
                            <input type="text" name="nomor_meja" value="{{ $mejaOtomatis ?? '01' }}" readonly class="w-full p-4 border border-stone-200 rounded-2xl bg-white font-black text-orange-700 text-center text-lg shadow-sm">
                        </div>

                        <div id="section-takeaway" class="hidden md:col-span-1 bg-orange-100/50 p-4 rounded-2xl border border-orange-200 animate-fade-in">
                            <p class="text-[10px] text-orange-800 font-black uppercase tracking-widest">Info:</p>
                            <p class="text-xs text-stone-600 mt-1 font-medium">Pesanan akan dikemas rapi. Silakan ambil di kasir sesuai jam booking.</p>
                        </div>
                    </div>

                    <div id="section-alamat" class="hidden animate-fade-in">
                        <label class="block text-[10px] font-black text-orange-900 mb-2 uppercase tracking-widest">Alamat Pengiriman</label>
                        <textarea name="alamat" rows="3" class="w-full p-4 border border-stone-200 rounded-2xl text-sm bg-white shadow-sm focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Tulis alamat lengkap Anda..."></textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-orange-900 mb-2 uppercase tracking-widest">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="w-full p-4 border border-stone-200 rounded-2xl text-sm bg-white shadow-sm font-black text-stone-700">
                            <option value="cash">💵 Bayar Langsung di Kasir</option>
                            <option value="qris">📱 QRIS</option>
                        </select>
                    </div>

                    <div class="pt-6 grid grid-cols-1 gap-4">
                        <button type="submit" id="btn-submit" class="w-full py-5 bg-orange-700 text-white rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-orange-800 shadow-xl transition-all active:scale-[0.98] disabled:bg-stone-300">
                            Konfirmasi Pesanan Sekarang
                        </button>
                        <a href="{{ route('menu') }}" class="text-center text-xs font-bold text-stone-400 uppercase tracking-widest hover:text-orange-700 transition-colors py-2">
                            ← Kembali Tambah Menu
                        </a>
                    </div>
                </form>
            </div>
        @else
            <div class="text-center py-32 px-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-stone-50 rounded-full text-5xl mb-6 shadow-inner">☕</div>
                <h2 class="text-2xl font-black text-stone-800 uppercase tracking-widest mb-2">Keranjang Kosong</h2>
                <p class="text-stone-400 mb-10 max-w-xs mx-auto text-sm">Sepertinya Anda belum memilih menu favorit dari Valeria Coffee hari ini.</p>
                <a href="{{ route('menu') }}" class="inline-block px-12 py-5 bg-orange-700 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-orange-800 transition-all shadow-2xl active:scale-95">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>

    <script>
        function toggleLayanan() {
            const layanan = document.getElementById('metode_layanan').value;
            const sectionMeja = document.getElementById('section-meja');
            const sectionAlamat = document.getElementById('section-alamat');
            const sectionTakeAway = document.getElementById('section-takeaway');

            sectionMeja.classList.add('hidden');
            sectionAlamat.classList.add('hidden');
            sectionTakeAway.classList.add('hidden');

            if (layanan === 'dine_in') sectionMeja.classList.remove('hidden');
            else if (layanan === 'delivery') sectionAlamat.classList.remove('hidden');
            else if (layanan === 'take_away') sectionTakeAway.classList.remove('hidden');
        }

        function updateQuantity(id, action) {
            fetch(`/cart/update/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ action: action })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) window.location.reload();
                else alert(data.error || "Gagal memperbarui jumlah.");
            })
            .catch(() => alert("Terjadi kesalahan koneksi."));
        }

        const selectJam = document.getElementById('jam_booking');
        const inputTgl = document.getElementById('tanggal_booking');

        function filterJam() {
            const sekarang = new Date();
            const tglPilihan = inputTgl.value;
            const tglHariIni = sekarang.toISOString().split('T')[0];
            const options = selectJam.options;

            for (let i = 1; i < options.length; i++) {
                const [jam, menit] = options[i].value.split(':');
                const waktuOpsi = new Date();
                waktuOpsi.setHours(parseInt(jam), parseInt(menit), 0);

                if (tglPilihan === tglHariIni && waktuOpsi < sekarang) {
                    options[i].disabled = true;
                    options[i].style.display = 'none';
                } else {
                    options[i].disabled = false;
                    options[i].style.display = 'block';
                }
            }
        }

        document.getElementById('form-pembayaran')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('btn-submit');
            btn.disabled = true;
            btn.innerHTML = `<span class="flex items-center justify-center tracking-normal uppercase"><svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Memproses...</span>`;

            fetch("{{ route('order.simpan') }}", {
                method: "POST",
                body: new FormData(this),
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Accept": "application/json" }
            })
            .then(res => res.json())
            .then(data => {
                // Ganti baris 166 yang lama dengan ini:
            if (data.success) {
                window.location.href = "/order/konfirmasi/" + data.order_id;
            }
            })
            .catch(() => { 
                alert("Koneksi bermasalah."); 
                btn.disabled = false; 
                btn.innerHTML = "Konfirmasi Pesanan Sekarang";
            });
        });

        window.onload = function() {
            filterJam();
            toggleLayanan();
        };
        inputTgl?.addEventListener('change', filterJam);
    </script>
</body>
</html>