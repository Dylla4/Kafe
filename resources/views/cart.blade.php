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
        .coffee-gradient { background: linear-gradient(135deg, #3C2A21 0%, #1A120B 100%); }
        .input-focus:focus { border-color: #A06040; box-shadow: 0 0 0 4px rgba(160, 96, 64, 0.1); }
        .animate-in { animation: slideUp 0.5s ease-out forwards; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        /* Menghilangkan arrow pada input number jika masih ada */
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    </style>
</head>
<body class="bg-[#F9F8F6] text-stone-800 p-4 md:p-12">
    <div class="max-w-4xl mx-auto animate-in">
        
        {{-- Top Navigation --}}
        <div class="flex items-center justify-between mb-8 px-4">
            <a href="{{ url('/') }}" class="group flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-stone-400 hover:text-[#3C2A21] transition-all">
                <span class="text-lg group-hover:-translate-x-1 transition-transform">←</span> Kembali ke Home
            </a>
            <div class="text-[10px] font-black uppercase tracking-widest text-stone-300">Valeria Coffee</div>
        </div>

        <div class="bg-white rounded-[3rem] shadow-2xl shadow-stone-200/50 overflow-hidden border border-stone-100">
            {{-- Header Section --}}
            <div class="p-10 border-b border-stone-50 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-4xl font-black tracking-tighter text-[#3C2A21] uppercase">
                        Keranjang <span class="text-orange-700 italic">Saya</span>
                    </h1>
                    <p class="text-stone-400 text-xs font-bold uppercase tracking-widest mt-2">Review your selected caffeine picks</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-orange-50 text-orange-700 px-5 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest">
                        {{ count($cartItems ?? []) }} Items
                    </div>
                </div>
            </div>

            @if(!empty($cartItems) && count($cartItems) > 0)
                <div class="p-4 md:p-10">
                    {{-- Table Section --}}
                    <div class="overflow-x-auto mb-12">
                        <table class="w-full text-left border-separate border-spacing-y-4">
                            <thead>
                                <tr class="text-stone-400 uppercase text-[9px] font-black tracking-[0.2em] px-4">
                                    <th class="pb-2 pl-4">Produk</th>
                                    <th class="pb-2 hidden md:table-cell">Harga Satuan</th>
                                    <th class="pb-2 text-center">Kuantitas</th>
                                    <th class="pb-2 text-right pr-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-50">
                                @php $total = 0; @endphp
                                @foreach($cartItems as $id => $details)
                                    @php $total += $details['harga'] * $details['quantity']; @endphp
                                    <tr class="group bg-stone-50/40 rounded-3xl overflow-hidden hover:bg-white hover:shadow-xl hover:shadow-stone-100 transition-all">
                                        <td class="py-6 pl-4 rounded-l-[2rem]">
                                            <div class="flex items-center gap-5">
                                                <div class="w-20 h-20 shrink-0 bg-white rounded-2xl overflow-hidden shadow-sm border border-stone-100 p-1">
                                                    @if(isset($details['foto']) && $details['foto'])
                                                        <img src="{{ asset($details['foto']) }}" class="w-full h-full object-cover rounded-xl">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-3xl bg-stone-50 rounded-xl">☕</div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="block font-black text-[#3C2A21] uppercase text-sm tracking-tight mb-1">{{ $details['nama_menu'] }}</span>
                                                    <span class="text-[10px] text-orange-600 font-bold uppercase tracking-widest md:hidden">Rp {{ number_format($details['harga'], 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="hidden md:table-cell text-stone-400 font-bold text-xs uppercase tracking-wider">
                                            Rp {{ number_format($details['harga'], 0, ',', '.') }}
                                        </td>
                                        <td class="py-6 text-center">
                                            <div class="inline-flex items-center gap-4 bg-white p-2 rounded-2xl shadow-sm border border-stone-100">
                                                <button type="button" onclick="updateQuantity('{{ $id }}', 'decrease')" class="w-8 h-8 flex items-center justify-center rounded-xl bg-stone-50 text-stone-600 hover:bg-red-50 hover:text-red-600 transition-all active:scale-90 font-black">-</button>
                                                <span class="font-black text-[#3C2A21] text-sm min-w-[20px]">{{ $details['quantity'] }}</span>
                                                <button type="button" onclick="updateQuantity('{{ $id }}', 'increase')" class="w-8 h-8 flex items-center justify-center rounded-xl bg-[#3C2A21] text-white hover:bg-orange-800 transition-all shadow-md active:scale-90 font-black">+</button>
                                            </div>
                                        </td>
                                        <td class="text-right pr-4 rounded-r-[2rem]">
                                            <span class="font-black text-[#3C2A21] text-base">Rp {{ number_format($details['harga'] * $details['quantity'], 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Summary & Checkout Form --}}
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                        <div class="lg:col-span-7">
                            <form id="form-pembayaran" action="{{ route('checkout.proses') }}" method="POST" class="space-y-8">
                                @csrf
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-1 bg-orange-700 h-6 rounded-full"></div>
                                    <h3 class="text-[11px] font-black text-[#3C2A21] uppercase tracking-[0.2em]">Informasi Pengiriman</h3>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="md:col-span-2">
                                        <label class="block text-[9px] font-black text-stone-400 mb-2 uppercase tracking-widest ml-1">Nama Pemesan</label>
                                        <input type="text" name="nama_pemesan" value="{{ auth()->user()->name ?? 'Pelanggan' }}" readonly class="w-full p-4 rounded-2xl border-none bg-stone-50 text-sm font-bold text-stone-500 shadow-inner outline-none">
                                    </div>

                                    <div>
                                        <label class="block text-[9px] font-black text-stone-400 mb-2 uppercase tracking-widest ml-1">Tanggal Pesan</label>
                                        {{-- Ganti baris input tanggal_booking dengan ini --}}
                                        <input type="date" 
                                                name="tanggal_booking" 
                                                id="tanggal_booking" 
                                                min="{{ date('Y-m-d') }}" 
                                                max="{{ date('Y-m-d', strtotime('+7 days')) }}" 
                                                value="{{ date('Y-m-d') }}" 
                                                class="w-full p-4 border border-stone-100 rounded-2xl text-sm bg-stone-50 focus:bg-white input-focus shadow-sm transition-all font-bold" 
                                                required>
                                    </div>

                                    <div>
                                        <label class="block text-[9px] font-black text-stone-400 mb-2 uppercase tracking-widest ml-1" id="label-jam">Waktu Pengambilan</label>
                                        <select name="jam_booking" id="jam_booking" class="w-full p-4 border border-stone-100 rounded-2xl text-sm bg-stone-50 focus:bg-white input-focus shadow-sm transition-all font-bold cursor-pointer" required>
                                            <option value="" disabled selected>Pilih Jam</option>
                                        </select>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-[9px] font-black text-stone-400 mb-2 uppercase tracking-widest ml-1">Metode Layanan</label>
                                        <div class="grid grid-cols-3 gap-3">
                                            <label class="cursor-pointer">
                                                <input type="radio" name="jenis_pesanan" value="dine_in" checked onchange="toggleLayanan()" class="hidden peer">
                                                <div class="text-center p-3 rounded-2xl border border-stone-100 bg-stone-50 peer-checked:bg-orange-700 peer-checked:text-white peer-checked:border-orange-700 transition-all font-bold text-[10px] uppercase tracking-tighter shadow-sm">🍽️ Makan</div>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="jenis_pesanan" value="take_away" onchange="toggleLayanan()" class="hidden peer">
                                                <div class="text-center p-3 rounded-2xl border border-stone-100 bg-stone-50 peer-checked:bg-orange-700 peer-checked:text-white peer-checked:border-orange-700 transition-all font-bold text-[10px] uppercase tracking-tighter shadow-sm">🥡 Ambil</div>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="jenis_pesanan" value="delivery" onchange="toggleLayanan()" class="hidden peer">
                                                <div class="text-center p-3 rounded-2xl border border-stone-100 bg-stone-50 peer-checked:bg-orange-700 peer-checked:text-white peer-checked:border-orange-700 transition-all font-bold text-[10px] uppercase tracking-tighter shadow-sm">🚚 Antar</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div id="section-meja" class="animate-in">
                            <label class="block text-[10px] font-black text-orange-900 mb-2 uppercase tracking-widest">Nomor Meja</label>
                            <input type="text" name="nomor_meja" value="{{ $mejaOtomatis ?? '01' }}" readonly class="w-full p-4 border border-stone-200 rounded-2xl bg-white font-black text-orange-700 text-center text-lg shadow-sm">
                        </div>


                                <div id="section-alamat" class="hidden animate-in">
                                    <label class="block text-[9px] font-black text-stone-400 mb-2 uppercase tracking-widest ml-1">Alamat Lengkap</label>
                                    <textarea name="alamat" id="input-alamat" rows="2" class="w-full p-4 border border-stone-100 rounded-2xl text-sm bg-stone-50 focus:bg-white input-focus shadow-sm transition-all" placeholder="Contoh: Jl. Kopi No. 123..."></textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-[9px] font-black text-stone-400 mb-2 uppercase tracking-widest ml-1">WhatsApp</label>
                                        <input type="text" name="nomor_wa" value="{{ auth()->user()->nomor_wa ?? '' }}" placeholder="628..." class="w-full p-4 rounded-2xl border border-stone-100 bg-stone-50 focus:bg-white input-focus shadow-sm transition-all text-sm font-bold" required>
                                    </div>
                                    <div>
                                        <label class="block text-[9px] font-black text-stone-400 mb-2 uppercase tracking-widest ml-1">Pembayaran</label>
                                        <select name="metode_pembayaran" class="w-full p-4 border border-stone-100 rounded-2xl text-sm bg-stone-50 focus:bg-white input-focus shadow-sm transition-all font-bold">
                                            <option value="cash">💵 Cash / Kasir</option>
                                            <option value="qris">📱 QRIS / E-Wallet</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- Final Total Card --}}
                        <div class="lg:col-span-5">
                            <div class="coffee-gradient p-8 rounded-[2.5rem] text-white shadow-2xl shadow-orange-900/20 sticky top-10">
                                <h4 class="text-[10px] font-black uppercase tracking-[0.3em] opacity-60 mb-8 border-b border-white/10 pb-4">Ringkasan Pesanan</h4>
                                
                                <div class="space-y-4 mb-10">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="opacity-70 font-medium">Subtotal Menu</span>
                                        <span class="font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="opacity-70 font-medium">Pajak (0%)</span>
                                        <span class="font-bold">Rp 0</span>
                                    </div>
                                    <div class="h-px bg-white/10 w-full my-4"></div>
                                    <div class="flex justify-between items-end">
                                        <span class="text-xs font-black uppercase tracking-widest">Total Bayar</span>
                                        <span class="text-2xl font-black">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <button type="submit" form="form-pembayaran" class="w-full py-5 bg-white text-[#1A120B] rounded-2xl font-black uppercase tracking-[0.2em] text-[10px] hover:bg-orange-50 shadow-xl transition-all active:scale-[0.98] flex items-center justify-center gap-3 group">
                                    <span>Konfirmasi Pesanan</span>
                                    <span class="text-lg group-hover:translate-x-1 transition-transform">→</span>
                                </button>
                                
                                <p class="text-[9px] text-center mt-6 opacity-40 font-bold uppercase tracking-widest italic">
                                    *Pastikan pesanan sudah sesuai
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-32 px-8">
                    <div class="relative inline-block mb-10">
                        <div class="absolute -inset-6 bg-stone-100 rounded-full blur-2xl opacity-50"></div>
                        <span class="relative text-8xl">🛒</span>
                    </div>
                    <h2 class="text-3xl font-black text-[#3C2A21] uppercase tracking-tighter mb-3">Keranjang Kosong</h2>
                    <p class="text-stone-400 mb-12 max-w-xs mx-auto text-sm font-medium">Sepertinya Anda belum memilih menu favorit..</p>
                    <a href="{{ url('/menu') }}" class="inline-block px-14 py-5 bg-[#3C2A21] text-white rounded-full font-black uppercase tracking-[0.2em] text-[10px] hover:bg-black transition-all shadow-2xl active:scale-95">Mulai Belanja</a>
                </div>
            @endif
        </div>
    </div>

    <script>
        // 1. Fungsi Update Kuantitas (+ dan -)
        function updateQuantity(id, action) {
            fetch(`/cart/update/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ action: action })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Gagal memperbarui item.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan sistem.');
            });
        }

        // 2. Fungsi Toggle Layanan
        function toggleLayanan() {
    const layanan = document.querySelector('input[name="jenis_pesanan"]:checked').value;
    const sectionAlamat = document.getElementById('section-alamat');
    const sectionMeja = document.getElementById('section-meja'); // Tambahkan ini
    const inputAlamat = document.getElementById('input-alamat');
    const labelJam = document.getElementById('label-jam');
    const opsiCash = document.querySelector('option[value="cash"]');
    const selectMetode = document.querySelector('select[name="metode_pembayaran"]');

    // Reset Default
    sectionAlamat.classList.add('hidden');
    sectionMeja.classList.remove('hidden'); // Default meja muncul
    inputAlamat.required = false;
    opsiCash.disabled = false;
    opsiCash.style.display = 'block';

    if (layanan === 'dine_in') {
        labelJam.innerText = 'Jam Booking Meja';
    } else if (layanan === 'take_away') {
        labelJam.innerText = 'Jam Ambil di Kasir';
        sectionMeja.classList.add('hidden'); // Sembunyikan meja
    } else if (layanan === 'delivery') {
        labelJam.innerText = 'Jam Pengantaran';
        sectionAlamat.classList.remove('hidden');
        sectionMeja.classList.add('hidden'); // Sembunyikan meja
        inputAlamat.required = true; 
        selectMetode.value = 'qris'; 
        opsiCash.disabled = true;
        opsiCash.style.display = 'none';
    }
}

        document.addEventListener('DOMContentLoaded', function() {
        const tanggalInput = document.getElementById('tanggal_booking');
        const jamSelect = document.getElementById('jam_booking');

        function generateJamOptions() {
    const selectedDate = tanggalInput.value;
    const now = new Date();
    const today = now.toISOString().split('T')[0];
    
    const currentHour = now.getHours();
    const currentMinute = now.getMinutes();

    jamSelect.innerHTML = '<option value="" disabled selected>Pilih Jam</option>';

    for (let h = 9; h <= 22; h++) {
        ['00', '30'].forEach(m => {
            if (h === 22 && m === '30') return;

            const jamStr = h.toString().padStart(2, '0') + ':' + m;
            const optionHour = h;
            const optionMinute = parseInt(m);

            let isDisabled = false;

            // --- TARUH DI SINI (MENGGANTIKAN LOGIKA LAMA) ---
            if (selectedDate === today) {
                // Menambah buffer 15 menit agar pelanggan tidak pesan terlalu mepet
                const bufferTime = new Date(now.getTime() + 15 * 60000); 
                const bHour = bufferTime.getHours();
                const bMinute = bufferTime.getMinutes();

                if (optionHour < bHour || (optionHour === bHour && optionMinute <= bMinute)) {
                    isDisabled = true;
                }
            }

                // 4. Masukkan ke dalam Select jika tidak disabled
                if (!isDisabled) {
                    const option = document.createElement('option');
                    option.value = jamStr;
                    option.text = jamStr;
                    jamSelect.appendChild(option);
                }
            });
        }
    }

        // Jalankan saat tanggal berubah
        tanggalInput.addEventListener('change', generateJamOptions);
    
        // Jalankan pertama kali saat halaman dibuka
        generateJamOptions();
});
    </script>
</body>
</html>