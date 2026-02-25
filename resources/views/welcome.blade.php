<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-stone-50 text-stone-800 font-sans scroll-smooth">

@php
    $cart = session('cart', []);
@endphp

<!-- ================= NAVBAR ================= -->
<nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">

        <h1 class="text-2xl font-bold text-orange-700 tracking-wide">
            ☕ Valeria Coffee
        </h1>

        <div class="flex items-center gap-8">
            <div class="hidden md:flex gap-8 font-medium">
                <a href="#beranda" class="hover:text-orange-600 transition">Beranda</a>
                <a href="#tentang" class="hover:text-orange-600 transition">Tentang</a>
                <a href="#menu" class="hover:text-orange-600 transition">Menu</a>
                <a href="#kontak" class="hover:text-orange-600 transition">Kontak</a>
            </div>

            <a href="{{ url('/cart') }}"
               class="bg-orange-700 hover:bg-orange-800 text-white px-6 py-2 rounded-full font-semibold shadow-lg transition">
                🛒 Keranjang
            </a>
        </div>
    </div>
</nav>

<!-- ================= HERO / BERANDA ================= -->
<header id="beranda" class="relative min-h-screen flex items-center justify-center text-center text-white overflow-hidden">

    <img src="img/kopi.jpg"
         class="absolute inset-0 w-full h-full object-cover"
         alt="Coffee Background">

    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative z-10 px-6 max-w-3xl mx-auto">
        <h2 class="text-2xl md:text-4xl font-extrabold leading-tight mb-6">
            Cita Rasa Terbaik di Setiap Tegukan
        </h2>

        <p class="text-base md:text-lg text-stone-200 leading-relaxed mb-10">
            Dibuat dengan biji kopi pilihan terbaik yang diproses secara teliti
            oleh barista berpengalaman untuk menghadirkan cita rasa yang kaya,
            hangat, dan berkelas di setiap tegukan.
        </p>

        <a href="#menu"
           class="inline-block bg-orange-700 hover:bg-orange-800
                  px-10 py-4 rounded-full font-bold text-lg
                  transition duration-300 shadow-2xl">
            Lihat Menu
        </a>
    </div>
</header>

<!-- ================= TENTANG ================= -->
<section id="tentang" class="py-20 bg-white px-6">
    <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-8 items-center">

        <!-- FOTO -->
        <div class="flex justify-center md:justify-end">
            <img src="img/poto.jpg"
                 alt="Tentang Valeria Coffee"
                 class="rounded-3xl shadow-xl w-72 md:w-80 object-cover hover:scale-105 transition duration-500">
        </div>

        <!-- TEKS -->
        <div>
            <h2 class="text-4xl md:text-5xl font-bold mb-5 leading-tight">
                Tentang Valeria Coffee
            </h2>

            <p class="text-lg md:text-xl text-stone-600 leading-relaxed mb-5">
                Valeria Coffee hadir untuk menghadirkan pengalaman menikmati kopi
                yang berbeda — bukan hanya sekadar minuman, tetapi momen
                yang hangat dan berkesan di setiap pertemuan.
            </p>

            <p class="text-lg text-stone-600 leading-relaxed">
                Kami menggunakan biji kopi pilihan berkualitas tinggi yang diracik
                dengan teknik terbaik oleh barista profesional untuk menciptakan
                cita rasa yang konsisten, kaya, dan memuaskan.
            </p>
        </div>

    </div>
</section>

<!-- ================= MENU ================= -->
<section id="menu" class="max-w-6xl mx-auto py-24 px-6">

    <h2 class="text-3xl font-bold text-center mb-16">
        Menu Pilihan Kami
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

        @foreach($menus as $m)
            @php
                $sid = (string) $m->id;
                $qty = (int)($cart[$sid]['quantity'] ?? ($cart[$sid]['qty'] ?? 0));
            @endphp

            <div class="bg-white rounded-3xl shadow-md hover:shadow-2xl transition duration-300 overflow-hidden group">

                <div class="relative w-full h-60 overflow-hidden">
                    <img src="{{ asset($m->foto) }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                         alt="{{ $m->nama_menu }}">
                </div>

                <div class="p-6">

                    <span class="text-xs font-semibold uppercase text-orange-600 tracking-wider">
                        {{ $m->kategori }}
                    </span>

                    <h3 class="text-xl font-bold mt-2">
                        {{ $m->nama_menu }}
                    </h3>

                    <p class="text-2xl font-extrabold mt-4">
                        Rp {{ number_format($m->harga) }}
                    </p>

                    <div class="mt-6" id="action-{{ $m->id }}">
                        @if($qty > 0)
                            <div class="flex items-center justify-between gap-3">
                                <button type="button"
                                        onclick="decreaseItem({{ $m->id }})"
                                        class="w-12 h-12 rounded-xl border border-stone-200 hover:bg-stone-100 font-bold text-lg">
                                    -
                                </button>

                                <span id="qty-{{ $m->id }}" class="min-w-6 text-center text-lg font-bold">
                                    {{ $qty }}
                                </span>

                                <button type="button"
                                        onclick="increaseItem({{ $m->id }})"
                                        class="w-12 h-12 rounded-xl border border-stone-200 hover:bg-stone-100 font-bold text-lg">
                                    +
                                </button>
                            </div>
                        @else
                            <button type="button"
                                    onclick="addFirst({{ $m->id }})"
                                    class="w-full bg-stone-900 hover:bg-orange-700 text-white py-3 rounded-xl font-semibold transition">
                                + Tambah ke Pesanan
                            </button>
                        @endif
                    </div>

                </div>
            </div>
        @endforeach

    </div>
</section>

<!-- ================= KONTAK ================= -->
<footer id="kontak" class="bg-stone-900 text-stone-400 py-20 px-6">
    <div class="max-w-4xl mx-auto text-center">

        <h3 class="text-white text-2xl font-bold mb-10">
            Kontak & Lokasi
        </h3>

        <div class="space-y-6 text-lg">
            <p>
                📍
                <a href="https://www.google.com/maps/search/Jl.+Kopi+Nikmat+No.+123+Indonesia"
                   target="_blank"
                   class="hover:text-orange-400 transition">
                    Jl. Kopi Nikmat No. 123, Indonesia
                </a>
            </p>

            <p>🕒 08:00 — 22:00 WIB</p>

            <p>
                📱
                <a href="https://wa.me/6281234567890"
                   target="_blank"
                   class="hover:text-green-400 transition">
                    +62 812-3456-7890
                </a>
            </p>

            <p>
                📷
                <a href="https://instagram.com/jaliicoffee"
                   target="_blank"
                   class="hover:text-pink-400 transition">
                    @jaliicoffee
                </a>
            </p>

            <p>
                ✉️
                <a href="mailto:jaliicoffee@gmail.com"
                   class="hover:text-blue-400 transition">
                    jaliicoffee@gmail.com
                </a>
            </p>
        </div>

        <div class="mt-12 text-sm text-stone-500">
            © 2026 Valeria Coffee. All rights reserved.
        </div>
    </div>
</footer>

<script>
const CSRF_TOKEN = @json(csrf_token());

async function post(url) {
    const res = await fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    });
    if (!res.ok) throw new Error('Request gagal: ' + res.status);
    return true;
}

function renderQtyControls(id, qty) {
    const box = document.getElementById('action-' + id);
    if (!box) return;

    if (qty <= 0) {
        box.innerHTML = `
            <button type="button"
                    onclick="addFirst(${id})"
                    class="w-full bg-stone-900 hover:bg-orange-700 text-white py-3 rounded-xl font-semibold transition">
                + Tambah ke Pesanan
            </button>
        `;
        return;
    }

    box.innerHTML = `
        <div class="flex items-center justify-between gap-3">
            <button type="button"
                    onclick="decreaseItem(${id})"
                    class="w-12 h-12 rounded-xl border border-stone-200 hover:bg-stone-100 font-bold text-lg">
                -
            </button>

            <span id="qty-${id}" class="min-w-6 text-center text-lg font-bold">${qty}</span>

            <button type="button"
                    onclick="increaseItem(${id})"
                    class="w-12 h-12 rounded-xl border border-stone-200 hover:bg-stone-100 font-bold text-lg">
                +
            </button>
        </div>
    `;
}

async function addFirst(id) {
    renderQtyControls(id, 1);
    try {
        await post(`/cart/add/${id}`);
    } catch (e) {
        renderQtyControls(id, 0);
        alert('Gagal menambahkan pesanan. Coba lagi ya.');
    }
}

async function increaseItem(id) {
    const qtyEl = document.getElementById('qty-' + id);
    const current = qtyEl ? parseInt(qtyEl.innerText || '0', 10) : 0;
    const next = current + 1;

    if (qtyEl) qtyEl.innerText = next;

    try {
        await post(`/cart/add/${id}`);
    } catch (e) {
        if (qtyEl) qtyEl.innerText = current;
        alert('Gagal menambah jumlah. Coba lagi ya.');
    }
}

async function decreaseItem(id) {
    const qtyEl = document.getElementById('qty-' + id);
    const current = qtyEl ? parseInt(qtyEl.innerText || '0', 10) : 0;
    const next = current - 1;

    if (next <= 0) {
        renderQtyControls(id, 0);
    } else {
        if (qtyEl) qtyEl.innerText = next;
    }

    try {
        await post(`/cart/decrease/${id}`);
    } catch (e) {
        renderQtyControls(id, current);
        alert('Gagal mengurangi jumlah. Coba lagi ya.');
    }
}
</script>

</body>
</html>