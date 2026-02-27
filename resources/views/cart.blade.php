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

        <div class="flex items-center justify-between gap-4 mb-8">
            <h1 class="text-3xl font-bold flex items-center gap-2">🛒 Keranjang Belanja Anda</h1>

            <a href="{{ route('home') }}" class="text-orange-700 font-bold hover:underline">
                + Tambahkan Pesanan
            </a>
        </div>

        {{-- Flash message --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 font-semibold">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 font-semibold">
                ❌ {{ session('error') }}
            </div>
        @endif

        @php
            $cart = session('cart', []);
            $isEmpty = empty($cart);
        @endphp

        {{-- TABEL KERANJANG: hanya tampil kalau ada item --}}
        @if(!$isEmpty)
            <div class="overflow-x-auto">
                <table class="w-full text-left mb-10">
                    <thead class="border-b-2 border-stone-100 text-stone-400 uppercase text-sm">
                    <tr>
                        <th class="py-3">Menu</th>
                        <th>Harga</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-right">Subtotal</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                    </thead>

                    <tbody>
                    @php $total = 0; @endphp

                    @foreach($cart as $id => $details)
                        @php
                            $harga = (int)($details['harga'] ?? 0);
                            $qty   = (int)($details['quantity'] ?? ($details['qty'] ?? 1));
                            $nama  = $details['nama_menu'] ?? ($details['name'] ?? 'Menu');
                            $subtotal = $harga * $qty;
                            $total += $subtotal;
                        @endphp

                        <tr class="border-b border-stone-50 align-middle">
                            <td class="py-4 font-semibold">
                                <div class="flex items-center gap-3">
                                    @if(!empty($details['foto']))
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($details['foto']) }}"
                                             class="w-12 h-12 rounded-xl object-cover border" alt="">
                                    @endif
                                    <div>
                                        <div class="font-bold">{{ $nama }}</div>
                                        @if(!empty($details['kategori']))
                                            <div class="text-xs text-stone-400 uppercase tracking-wider">{{ $details['kategori'] }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td>Rp {{ number_format($harga) }}</td>

                            <td class="text-center">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('cart.decrease', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="w-9 h-9 rounded-lg border border-stone-200 hover:bg-stone-100 font-bold">
                                            -
                                        </button>
                                    </form>

                                    <span class="min-w-7.5 font-bold">{{ $qty }}</span>

                                    <form action="{{ route('cart.add', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="w-9 h-9 rounded-lg border border-stone-200 hover:bg-stone-100 font-bold">
                                            +
                                        </button>
                                    </form>
                                </div>
                            </td>

                            <td class="text-right font-bold text-orange-700">
                                Rp {{ number_format($subtotal) }}
                            </td>

                            <td class="text-right">
                                <form action="{{ route('cart.remove', $id) }}" method="POST"
                                      onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-2 rounded-lg bg-red-50 text-red-700 border border-red-200 hover:bg-red-100 font-bold">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

            <div class="text-right mb-10">
                <p class="text-stone-500">Total Pembayaran:</p>
                <h2 class="text-4xl font-black text-stone-900">Rp {{ number_format($total) }}</h2>
            </div>
        @endif

        {{-- FORM SELALU TAMPIL --}}
        <div class="bg-orange-50 p-8 rounded-2xl border-2 border-orange-100 mt-6">
            <h3 class="text-xl font-bold mb-6 text-orange-800 uppercase tracking-wider">Lengkapi Data Pesanan</h3>

            <form action="{{ route('checkout.simpan') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-orange-900 mb-2">Nama Pemesan</label>
                    <input type="text" name="nama_pembeli" required
                           class="w-full p-3 border-2 border-orange-200 rounded-xl focus:outline-none focus:border-orange-500 transition"
                           placeholder="Masukkan nama Anda">
                </div>

                <div>
                    <label class="block text-sm font-bold text-orange-900 mb-2">Jenis Pesanan</label>
                    <select name="jenis_pesanan" required
                            class="w-full p-3 border-2 border-orange-200 rounded-xl focus:outline-none focus:border-orange-500 transition">
                        <option value="dine_in">Makan di Tempat</option>
                        <option value="take_away">Take Away</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-orange-900 mb-2">Nomor Meja</label>
                    <input type="text" name="nomor_meja"
                           class="w-full p-3 border-2 border-orange-200 rounded-xl focus:outline-none focus:border-orange-500 transition"
                           placeholder="Contoh: Meja 05">
                    <p class="text-xs text-stone-500 mt-1">Isi jika makan di tempat (boleh kosong jika take away).</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-orange-900 mb-2">Metode Pembayaran</label>
                    <select name="metode_pembayaran" required
                            class="w-full p-3 border-2 border-orange-200 rounded-xl focus:outline-none focus:border-orange-500 transition">
                        <option value="cash">Cash</option>
                        <option value="qris">QRIS</option>
                        <option value="transfer">Transfer</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-orange-900 mb-2">Catatan Tambahan</label>
                    <input type="text" name="catatan"
                           class="w-full p-3 border-2 border-orange-200 rounded-xl focus:outline-none focus:border-orange-500 transition"
                           placeholder="Contoh: Kopi minta panas">
                </div>

                <button type="submit"
                        @if($isEmpty) disabled @endif
                        class="w-full py-4 rounded-xl font-black text-xl uppercase tracking-widest mt-4
                               {{ $isEmpty
                                    ? 'bg-stone-300 text-stone-600 cursor-not-allowed'
                                    : 'bg-orange-700 text-white hover:bg-orange-800 transform hover:scale-[1.02] transition-all shadow-lg shadow-orange-200' }}">
                    Kirim Pesanan Sekarang
                </button>
                @if($isEmpty)
                <p class="text-sm text-stone-500 mt-2">
                    Tambahkan menu dulu agar bisa checkout.
                </p>
                @endif
            </form>
        </div>

    </div>
</div>

</body>
</html>