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
                        <tr class="border-b border-stone-50">
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
                        <input type="text" name="nama_pemesan" value="{{ auth()->user()->name ?? 'Pelanggan' }}" readonly class="w-full p-3 rounded-lg border bg-stone-100 text-sm cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-orange-900 mb-2 uppercase">Tipe Pesanan</label>
                        <select name="jenis_pesanan" id="pilihan_tipe" class="w-full p-3 border rounded-lg text-sm">
                            <option value="dine_in">Makan di Tempat</option>
                            <option value="take_away">Take Away</option>
                        </select>
                    </div>

                    <div id="kolom_alamat" class="hidden">
                        <label class="block text-xs font-bold text-orange-900 mb-2 uppercase">Alamat Pengiriman</label>
                        <textarea name="alamat" rows="3" class="w-full p-3 border rounded-lg text-sm" placeholder="Masukkan alamat lengkap..."></textarea>
                    </div>

                    <div id="container_meja">
                        <label class="block text-xs font-bold text-orange-900 mb-2 uppercase">Nomor Meja</label>
                        <input type="text" name="nomor_meja" value="Meja 01" class="w-full p-3 border rounded-lg bg-white font-bold text-orange-700 text-lg">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-orange-900 mb-2 uppercase">Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="pilihan_pembayaran" class="w-full p-3 border rounded-lg text-sm">
                            <option value="cash">Cash (Bayar di Kasir)</option>
                            <option value="transfer">Transfer (DANA/QRIS)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-orange-900 mb-2 uppercase">Catatan (Opsional)</label>
                        <textarea name="catatan" rows="2" class="w-full p-3 border rounded-lg text-sm" placeholder="Contoh: Kurangi gula..."></textarea>
                    </div>
                    
                    <div class="pt-6">
                        <button type="submit" id="btn-submit" class="w-full py-4 bg-orange-700 text-white rounded-xl font-bold uppercase tracking-widest hover:bg-orange-800 shadow-md transition-all active:scale-95">
                            Konfirmasi Pesanan
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="text-center py-20 bg-stone-50 rounded-2xl border-2 border-dashed border-stone-200">
                <div class="text-6xl mb-4">🛒</div>
                <h2 class="text-xl font-bold text-stone-600">Keranjang Kosong</h2>
                <a href="{{ route('menu') }}" class="mt-4 inline-block px-8 py-3 bg-orange-700 text-white rounded-xl font-bold">Lihat Menu</a>
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

        // Toggle Alamat vs Meja
        pilihanTipe?.addEventListener('change', function() {
            kolomAlamat.classList.toggle('hidden', this.value !== 'take_away');
            containerMeja.classList.toggle('hidden', this.value === 'take_away');
        });

        // Proses Simpan & Bayar
        form?.addEventListener('submit', function(e) {
            e.preventDefault();

            btnSubmit.disabled = true;
            btnSubmit.innerHTML = "PROCESSING..."; // Indikator loading

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
                if (data.error) {
                    alert("Gagal: " + data.error);
                    resetButton();
                    return;
                }

                // Jika Transfer, buka Midtrans Snap
                if (pilihanPembayaran.value === 'transfer' && data.snap_token) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) { window.location.href = "{{ route('order.history') }}"; },
                        onPending: function(result) { window.location.href = "{{ route('order.history') }}"; },
                        onError: function(result) { alert("Pembayaran Gagal!"); resetButton(); },
                        onClose: function() { 
                            // Tetap arahkan ke riwayat karena data sudah tersimpan di DB
                            window.location.href = "{{ route('order.history') }}"; 
                        }
                    });
                } else {
                    // Jika Cash, langsung pindah ke riwayat
                    window.location.href = "{{ route('order.history') }}";
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Terjadi kesalahan sistem.");
                resetButton();
            });
        });

        function resetButton() {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = "Konfirmasi Pesanan";
        }
    </script>
</body>
</html>