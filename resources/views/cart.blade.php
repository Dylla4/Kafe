<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Kafe Kita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="MASUKKAN_CLIENT_KEY_ANDA"></script>
</head>
<body class="bg-stone-50 text-stone-800 p-4 md:p-12">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl p-8 border border-stone-200">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <h1 class="text-3xl font-bold italic tracking-tight text-stone-900 flex items-center">
                <span class="mr-2">🛒</span> <span class="italic">Keranjang Saya</span>
            </h1>
            <a href="{{ route('menu') }}" class="inline-flex items-center px-5 py-2.5 bg-orange-100 text-orange-700 border border-orange-200 rounded-xl font-bold text-sm hover:bg-orange-200 transition-all active:scale-95 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pesanan
            </a>
        </div>

        @if(!empty($cartItems) && count($cartItems) > 0)
            @php $total = 0; @endphp
            
            <div class="overflow-x-auto mb-8">
                <table class="w-full text-left border-collapse">
                    <thead class="border-b-2 border-stone-100 text-stone-400 uppercase text-xs">
                        <tr>
                            <th class="py-3">Menu</th>
                            <th>Harga</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $id => $details)
                        @php $total += $details['harga'] * $details['quantity']; @endphp
                        <tr class="border-b border-stone-50 text-sm md:text-base">
                            <td class="py-4 font-bold">{{ $details['nama_menu'] }}</td>
                            <td>Rp {{ number_format($details['harga'], 0, ',', '.') }}</td>
                            <td class="text-center">{{ $details['quantity'] }}</td>
                            <td class="text-right font-bold text-orange-700">Rp {{ number_format($details['harga'] * $details['quantity'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-stone-50">
                            <td colspan="3" class="py-4 px-2 font-bold text-lg text-stone-700 text-right uppercase tracking-wider">Total Keseluruhan :</td>
                            <td class="py-4 text-right font-black text-2xl text-orange-800">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="bg-orange-50 p-6 rounded-2xl border border-orange-100">
                <h3 class="text-lg font-bold mb-6 text-orange-900 uppercase tracking-wide">Informasi Pesanan</h3>
                
                <form id="form-pembayaran" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-orange-900 mb-2 uppercase">Nama Pemesan</label>
                        <input type="text" name="nama_pemesan" value="{{ auth()->user()->name ?? 'Pelanggan' }}" readonly class="w-full p-3 rounded-lg border bg-stone-100 text-sm cursor-not-allowed outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-orange-900 mb-2 uppercase">Tanggal Booking</label>
                            <input type="date" name="tanggal_booking" id="tanggal_booking" class="w-full p-3 border border-stone-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-orange-500 outline-none transition-all" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-orange-900 mb-2 uppercase">Jam Booking</label>
                            <input type="time" name="jam_booking" id="jam_booking" class="w-full p-3 border border-stone-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-orange-500 outline-none transition-all" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-orange-900 mb-2 uppercase">Tipe Pesanan</label>
                        <select name="jenis_pesanan" id="pilihan_tipe" class="w-full p-3 border border-stone-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                            <option value="dine_in">Makan di Tempat</option>
                            <option value="take_away">Take Away</option>
                        </select>
                    </div>

                    <div id="kolom_alamat" class="hidden animate-fade-in">
                        <label class="block text-xs font-bold text-orange-900 mb-2 uppercase">Alamat Pengiriman</label>
                        <textarea name="alamat" rows="3" class="w-full p-3 border border-stone-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Masukkan alamat lengkap..."></textarea>
                    </div>

                    <div id="container_meja">
                        <label class="block text-xs font-bold text-orange-900 mb-2 uppercase">Nomor Meja</label>
                        <input type="text" name="nomor_meja" value="Meja 01" class="w-full p-3 border border-stone-200 rounded-lg bg-white font-bold text-orange-700 text-lg focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-orange-900 mb-2 uppercase">Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="pilihan_pembayaran" class="w-full p-3 border border-stone-200 rounded-lg text-sm bg-white font-bold focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                            <option value="cash">Cash (Bayar di Kasir)</option>
                            <option value="transfer">Transfer (DANA/QRIS via Midtrans)</option>
                        </select>
                    </div>

                    <div class="pt-4 space-y-3">
                        <button type="submit" id="btn-submit" class="w-full py-4 bg-orange-700 text-white rounded-xl font-bold uppercase tracking-widest hover:bg-orange-800 shadow-lg transition-all active:scale-95 disabled:bg-stone-400 disabled:cursor-not-allowed">
                            Konfirmasi Pesanan
                        </button>
                        <a href="{{ route('menu') }}" class="block w-full py-4 border-2 border-orange-700 text-orange-700 text-center rounded-xl font-bold uppercase tracking-widest hover:bg-orange-50 transition-all">
                            Kembali ke Menu
                        </a>
                    </div>
                </form>
            </div>
        @else
            <div class="text-center py-20">
                <div class="text-6xl mb-4 opacity-50">☕</div>
                <h2 class="text-2xl font-bold text-stone-400 mb-6">Keranjang Anda masih kosong</h2>
                <a href="{{ route('menu') }}" class="px-8 py-3 bg-orange-700 text-white rounded-xl font-bold uppercase tracking-widest hover:bg-orange-800 transition-all">
                    Lihat Menu Sekarang
                </a>
            </div>
        @endif
    </div>

    <script>
        const form = document.getElementById('form-pembayaran');
        const btnSubmit = document.getElementById('btn-submit');
        const pilihanTipe = document.getElementById('pilihan_tipe');
        const kolomAlamat = document.getElementById('kolom_alamat');
        const containerMeja = document.getElementById('container_meja');
        const pilihanPembayaran = document.getElementById('pilihan_pembayaran');

        // Toggle Alamat/Meja
        pilihanTipe?.addEventListener('change', function() {
            if(this.value === 'take_away') {
                kolomAlamat.classList.remove('hidden');
                containerMeja.classList.add('hidden');
            } else {
                kolomAlamat.classList.add('hidden');
                containerMeja.classList.remove('hidden');
            }
        });

        // Submit Logic
        form?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // UI Feedback
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = `
                <span class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                </span>
            `;

            const formData = new FormData(form);

            fetch("{{ route('checkout.simpan') }}", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.error || !data.success) {
                    alert("Gagal: " + (data.error || data.message));
                    resetButton();
                    return;
                }

                if (pilihanPembayaran.value === 'transfer') {
                    if (data.snap_token) {
                        window.snap.pay(data.snap_token, {
                            onSuccess: function(result) { window.location.href = "/payment/" + data.order_id; },
                            onPending: function(result) { window.location.href = "/payment/" + data.order_id; },
                            onError: function(result) { alert("Pembayaran Gagal!"); resetButton(); },
                            onClose: function() { alert('Anda menutup jendela pembayaran.'); resetButton(); }
                        });
                    } else {
                        alert("Gagal mendapatkan token pembayaran Midtrans.");
                        resetButton();
                    }
                } else {
                    window.location.href = "/payment/" + data.order_id;
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Terjadi kesalahan koneksi ke server.");
                resetButton();
            });
        });

        function resetButton() {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = "Konfirmasi Pesanan";
        }
    </script>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>