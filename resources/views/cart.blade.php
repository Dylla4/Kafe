<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Kafe Kita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 text-stone-800 p-4 md:p-12">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl p-8 border border-stone-200">
        <h1 class="text-3xl font-bold mb-8">🛒 Keranjang</h1>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-800 border border-green-200 font-semibold text-center">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Tabel Item Pesanan --}}
        @if(!empty($cartItems))
            <table class="w-full text-left mb-8">
                <thead class="border-b-2 border-stone-100 text-stone-400 uppercase text-xs">
                    <tr><th class="py-3">Menu</th><th>Harga</th><th class="text-center">Qty</th><th class="text-right">Subtotal</th></tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $id => $details)
                    <tr class="border-b border-stone-50">
                        <td class="py-4 font-bold">{{ $details['nama_menu'] }}</td>
                        <td>Rp {{ number_format($details['harga'], 0, ',', '.') }}</td>
                        <td class="text-center">{{ $details['quantity'] }}</td>
                        <td class="text-right font-bold text-orange-700">Rp {{ number_format($details['harga'] * $details['quantity'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center py-10">
                <p class="text-stone-400 mb-4">Keranjang Anda kosong.</p>
                <a href="{{ route('menu') }}" class="text-orange-700 font-bold underline">Lihat Menu Sekarang</a>
            </div>
        @endif

        {{-- Form Informasi Booking --}}
        <div class="bg-orange-50 p-6 rounded-2xl border border-orange-100">
            <h3 class="text-lg font-bold mb-4 text-orange-900 uppercase">Informasi Pesanan & Booking</h3>
            <form action="{{ route('checkout.simpan') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-orange-900 mb-1">NAMA PEMESAN</label>
                    <input type="text" name="nama_pemesan" value="{{ auth()->user()->name ?? 'Pelanggan' }}" readonly class="w-full p-2 rounded-lg border bg-stone-100 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-orange-900 mb-1 uppercase">Tanggal Booking</label>
                        <input type="date" name="tanggal_booking" required class="w-full p-2 border rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-orange-900 mb-1 uppercase">Jam Booking</label>
                        <input type="time" name="jam_booking" required class="w-full p-2 border rounded-lg text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-orange-900 mb-1 uppercase">Tipe</label>
                        <select name="jenis_pesanan" class="w-full p-2 border rounded-lg text-sm">
                            <option value="dine_in">Makan di Tempat</option>
                            <option value="take_away">Take Away</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-orange-900 mb-1 uppercase">Nomor Meja</label>
                        <input type="text" name="nomor_meja" value="{{ $mejaOtomatis }}" readonly class="w-full p-2 border rounded-lg bg-stone-100 font-bold text-orange-700">
                    </div>
                    <div class="mt-4">
                        <label class="block text-xs font-bold uppercase tracking-widest text-stone-500 mb-2">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="w-full bg-stone-50 border border-stone-200 rounded-2xl p-4 outline-none focus:border-[#A06040] transition">
                            <option value="cash">Tunai (Bayar di Kasir)</option>
                            <option value="dana">DANA</option>
                            <option value="qris">QRIS / Scan QR</option>
                        </select>
                    </div>
                </div>
                
                {{-- Tombol Oranye Solid --}}
                <div class="pt-4 space-y-3">
                    <button type="submit" class="w-full py-4 bg-orange-700 text-white rounded-xl font-bold uppercase tracking-widest hover:bg-orange-800 shadow-lg transition-all">
                        Konfirmasi Pesanan
                    </button>
                    <a href="{{ route('menu') }}" class="block w-full py-4 bg-orange-700 text-white text-center rounded-xl font-bold uppercase tracking-widest hover:bg-orange-800 shadow-lg transition-all">
                        Kembali ke Menu
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>