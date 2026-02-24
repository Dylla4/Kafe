<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Kafe Kita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 text-stone-800 p-6 md:p-12">

    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-stone-200">
        <div class="p-8">
            <h1 class="text-3xl font-bold mb-8 flex items-center">
                🛒 Keranjang Belanja Anda
            </h1>

            @if(session('cart') && count(session('cart')) > 0)
                <table class="w-full text-left mb-10">
                    <thead class="border-b-2 border-stone-100 text-stone-400 uppercase text-sm">
                        <tr>
                            <th class="py-3">Menu</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0 @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <tr class="border-b border-stone-50">
                                <td class="py-4 font-semibold">{{ $details['name'] }}</td>
                                <td>Rp {{ number_format($details['price']) }}</td>
                                <td>{{ $details['quantity'] }}x</td>
                                <td class="text-right font-bold text-orange-700">Rp {{ number_format($details['price'] * $details['quantity']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right mb-10">
                    <p class="text-stone-500">Total Pembayaran:</p>
                    <h2 class="text-4xl font-black text-stone-900">Rp {{ number_format($total) }}</h2>
                </div>

                <div class="bg-orange-50 p-8 rounded-2xl border-2 border-orange-100">
                    <h3 class="text-xl font-bold mb-6 text-orange-800 uppercase tracking-wider">Lengkapi Data Pesanan</h3>
                    
                    <form action="{{ route('checkout.simpan') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-orange-900 mb-2">Nama Pemesan</label>
                            <input type="text" name="nama_pembeli" required 
                                   class="w-full p-3 border-2 border-orange-200 rounded-xl focus:outline-none focus:border-orange-500 transition"
                                   placeholder="Masukkan nama Anda">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-orange-900 mb-2">Nomor Meja</label>
                                <input type="text" name="nomor_meja" required
                                       class="w-full p-3 border-2 border-orange-200 rounded-xl focus:outline-none focus:border-orange-500 transition"
                                       placeholder="Contoh: Meja 05">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-orange-900 mb-2">Catatan Tambahan</label>
                                <input type="text" name="catatan" 
                                       class="w-full p-3 border-2 border-orange-200 rounded-xl focus:outline-none focus:border-orange-500 transition"
                                       placeholder="Contoh: Kopi minta panas">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-orange-700 text-white py-4 rounded-xl font-black text-xl hover:bg-orange-800 transform hover:scale-[1.02] transition-all shadow-lg shadow-orange-200 uppercase tracking-widest mt-4">
                            Kirim Pesanan Sekarang
                        </button>
                    </form>
                </div>

            @else
                <div class="text-center py-20">
                    <p class="text-stone-400 text-xl mb-6">Keranjang Anda masih kosong...</p>
                    <a href="/" class="text-orange-700 font-bold border-2 border-orange-700 px-6 py-2 rounded-full hover:bg-orange-700 hover:text-white transition">Kembali ke Menu</a>
                </div>
            @endif
        </div>
    </div>

</body>
</html>