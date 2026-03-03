<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Valeria Coffee</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>html { scroll-behavior: smooth; }</style>
</head>

<body class="bg-stone-50 text-stone-800 font-sans scroll-smooth">

@php
  $cart = session('cart', []);
@endphp

<!-- ================= NAVBAR ================= -->
<nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
  <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-orange-700 tracking-wide">☕ Valeria Coffee</h1>

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
  <img src="img/kopi.jpg" class="absolute inset-0 w-full h-full object-cover" alt="Coffee Background">
  <div class="absolute inset-0 bg-black/60"></div>

  <div class="relative z-10 px-6 max-w-3xl mx-auto">
    <h2 class="text-2xl md:text-4xl font-extrabold leading-tight mb-6">Cita Rasa Terbaik di Setiap Tegukan</h2>
    <p class="text-base md:text-lg text-stone-200 leading-relaxed mb-10">
      Dibuat dengan biji kopi pilihan terbaik yang diproses secara teliti oleh barista berpengalaman.
    </p>

    <a href="#menu"
       class="inline-block bg-orange-700 hover:bg-orange-800 px-10 py-4 rounded-full font-bold text-lg transition duration-300 shadow-2xl">
      Lihat Menu
    </a>
  </div>
</header>

<!-- ================= TENTANG ================= -->
<section id="tentang" class="py-20 bg-white px-6">
  <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-8 items-center">
    <div class="flex justify-center md:justify-end">
      <img src="img/poto.jpg" alt="Tentang Valeria Coffee"
           class="rounded-3xl shadow-xl w-72 md:w-80 object-cover hover:scale-105 transition duration-500">
    </div>

    <div>
      <h2 class="text-4xl md:text-5xl font-bold mb-5 leading-tight">Tentang Valeria Coffee</h2>
      <p class="text-lg md:text-xl text-stone-600 leading-relaxed mb-5">
        Valeria Coffee hadir untuk menghadirkan pengalaman menikmati kopi yang berbeda.
      </p>
      <p class="text-lg text-stone-600 leading-relaxed">
        Kami menggunakan biji kopi pilihan berkualitas tinggi yang diracik dengan teknik terbaik.
      </p>
    </div>
  </div>
</section>

<!-- ================= MENU ================= -->
<section id="menu" class="max-w-6xl mx-auto py-24 px-6 bg-white">
  <div class="text-center mb-10">
    <h2 class="text-4xl font-extrabold text-stone-800 mb-4">Menu Pilihan Kami</h2>
    <p class="text-stone-500">Nikmati sajian terbaik kami.</p>
    <div class="w-24 h-1.5 bg-orange-500 mx-auto mt-6 rounded-full"></div>
  </div>

  @php
    $categories = $menus->whereNotIn('kategori', ['Offer', 'Promo', 'Today\'s Offer', 'OFFER'])
                       ->pluck('kategori')
                       ->unique();
  @endphp

  <div class="flex flex-wrap justify-center gap-4 mb-20">
    <a href="#menu"
       class="px-10 py-3 bg-orange-500 text-white font-bold rounded-full shadow-lg shadow-orange-200 transition-all duration-300 uppercase text-xs tracking-widest">
      Semua
    </a>

    @foreach($categories as $cat)
      <a href="#category-{{ Str::slug($cat) }}"
         class="px-10 py-3 bg-white border border-stone-200 text-stone-600 font-bold rounded-full shadow-sm hover:bg-orange-50 hover:text-orange-600 hover:border-orange-200 transition-all duration-300 uppercase text-xs tracking-widest">
        {{ $cat }}
      </a>
    @endforeach
  </div>

  <!-- ================= TODAY'S OFFER ================= -->
  <div class="mb-12 px-4 md:px-0">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-black text-stone-800 flex items-center gap-2">
        Today's Offer <span class="text-orange-500">🔥</span>
      </h2>
      <a href="#menu" class="text-orange-600 font-bold text-sm hover:underline">Lihat Semua →</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      @foreach($menus->where('kategori', 'Offer') as $m)
        @php
          $sid = (string) $m->id;
          $qty = (int)($cart[$sid]['quantity'] ?? ($cart[$sid]['qty'] ?? 0));
        @endphp

        <div class="bg-white rounded-3xl p-4 shadow-sm border border-stone-100 flex gap-5 items-center hover:shadow-md transition-shadow">
          <div class="relative w-32 h-32 shrink-0">
            <img src="{{ asset($m->foto) }}" class="w-full h-full object-cover rounded-2xl" alt="{{ $m->nama_menu }}">
            <div class="absolute -top-2 -right-2 bg-red-500 text-white text-[9px] font-bold px-2 py-1 rounded-lg shadow-sm">PROMO</div>
          </div>

          <div class="grow">
            <h3 class="font-bold text-lg text-stone-800 leading-tight mb-1">{{ $m->nama_menu }}</h3>
            <p class="text-[11px] text-stone-400 mb-3 line-clamp-2 italic">{{ $m->deskripsi ?? 'Paket hemat spesial hari ini' }}</p>
            <div class="flex items-baseline gap-2">
              <span class="font-black text-orange-600 text-lg">Rp {{ number_format($m->harga) }}</span>
              <span class="text-[10px] text-stone-300 line-through">Rp {{ number_format($m->harga + 5000) }}</span>
            </div>
          </div>

          <div id="action-offer-{{ $m->id }}" class="shrink-0">
            @if($qty > 0)
              <div class="flex items-center gap-3 bg-stone-50 px-3 py-2 rounded-2xl border border-stone-100">
                <button type="button" onclick="decreaseItem({{ $m->id }}, 'offer')"
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-stone-200 text-stone-600 hover:bg-orange-500 hover:text-white transition-all font-bold shadow-sm">-</button>
                <span id="qty-offer-{{ $m->id }}" class="text-lg font-bold text-stone-800 min-w-5 text-center">{{ $qty }}</span>
                <button type="button" onclick="increaseItem({{ $m->id }}, 'offer')"
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-stone-200 text-stone-600 hover:bg-orange-500 hover:text-white transition-all font-bold shadow-sm">+</button>
              </div>
            @else
              <button type="button" onclick="addFirst({{ $m->id }}, 'offer')"
                      class="bg-green-600 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-lg shadow-green-100 hover:bg-stone-900 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>
              </button>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <!-- ================= BEST SELLER ================= -->
  @if($menus->where('is_best_seller', true)->count() > 0)
    <div class="mb-16">
      <div class="flex items-center gap-4 mb-8">
        <span class="bg-orange-100 text-orange-600 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest">Best Seller</span>
        <div class="grow h-px bg-stone-100"></div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($menus->where('is_best_seller', true) as $m)
          @php
            $sid = (string) $m->id;
            $qty = (int)($cart[$sid]['quantity'] ?? ($cart[$sid]['qty'] ?? 0));
          @endphp

          <div class="flex items-center gap-5 p-4 bg-orange-50/50 rounded-3xl border border-orange-100 hover:shadow-lg transition duration-300">
            <img src="{{ asset($m->foto) }}" class="w-24 h-24 object-cover rounded-2xl shadow-sm" alt="{{ $m->nama_menu }}">

            <div class="grow flex items-center justify-between gap-4">
              <div>
                <h4 class="font-bold text-stone-800">{{ $m->nama_menu }}</h4>
                <p class="text-orange-600 font-black">Rp {{ number_format($m->harga) }}</p>
              </div>

              <div id="action-bs-{{ $m->id }}" class="shrink-0">
                @if($qty > 0)
                  <div class="flex items-center gap-3 bg-white px-3 py-2 rounded-2xl border border-orange-100">
                    <button type="button" onclick="decreaseItem({{ $m->id }}, 'bs')"
                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-stone-200 hover:bg-orange-500 hover:text-white transition-all font-bold">-</button>
                    <span id="qty-bs-{{ $m->id }}" class="text-base font-bold min-w-5 text-center">{{ $qty }}</span>
                    <button type="button" onclick="increaseItem({{ $m->id }}, 'bs')"
                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-stone-200 hover:bg-orange-500 hover:text-white transition-all font-bold">+</button>
                  </div>
                @else
                  <button type="button" onclick="addFirst({{ $m->id }}, 'bs')"
                          class="bg-green-600 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-lg shadow-green-100 hover:bg-stone-900 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                  </button>
                @endif
              </div>

            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif

  <!-- ================= KATEGORI MENU ================= -->
  @foreach($categories as $cat)
    <div class="mb-20 scroll-mt-24" id="category-{{ Str::slug($cat) }}">
      <div class="flex items-center gap-4 mb-10">
        <h3 class="text-2xl font-bold text-stone-800 uppercase tracking-wider">{{ $cat }}</h3>
        <div class="grow h-px bg-stone-200"></div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($menus->where('kategori', $cat) as $m)
          @php
            $sid = (string) $m->id;
            $qty = (int)($cart[$sid]['quantity'] ?? ($cart[$sid]['qty'] ?? 0));
          @endphp

          <div class="bg-white rounded-4xl border border-stone-100 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden group">
            <div class="relative w-full h-64 overflow-hidden bg-stone-100">
              <img src="{{ asset($m->foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="{{ $m->nama_menu }}">
            </div>

            <div class="p-8 text-center">
              <h4 class="text-xl font-bold text-stone-800 mb-2">{{ $m->nama_menu }}</h4>
              <p class="text-2xl font-black text-stone-900 mb-6">Rp {{ number_format($m->harga) }}</p>

              <div id="action-cat-{{ $m->id }}" class="flex justify-center w-full">
                @if($qty > 0)
                  <div class="flex items-center gap-6 bg-stone-50 px-4 py-2 rounded-2xl border border-stone-100">
                    <button type="button" onclick="decreaseItem({{ $m->id }}, 'cat')"
                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-stone-200 text-stone-600 hover:bg-orange-500 hover:text-white transition-all font-bold shadow-sm">-</button>
                    <span id="qty-cat-{{ $m->id }}" class="text-xl font-bold text-stone-800 min-w-5 text-center">{{ $qty }}</span>
                    <button type="button" onclick="increaseItem({{ $m->id }}, 'cat')"
                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-stone-200 text-stone-600 hover:bg-orange-500 hover:text-white transition-all font-bold shadow-sm">+</button>
                  </div>
                @else
                  <button type="button" onclick="addFirst({{ $m->id }}, 'cat')"
                          class="w-full bg-orange-600 text-white py-4 rounded-2xl font-bold hover:bg-stone-900 transition-all shadow-lg shadow-stone-200">
                    + Tambah ke Pesanan
                  </button>
                @endif
              </div>

            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endforeach
</section>

<!-- ================= KONTAK (BARU) ================= -->
<section id="kontak" class="bg-stone-900 text-white py-20 px-6">
  <div class="max-w-6xl mx-auto">
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-extrabold">Hubungi Kami</h2>
      <p class="text-stone-300 mt-3">Klik untuk langsung terhubung</p>
      <div class="w-24 h-1.5 bg-orange-500 mx-auto mt-6 rounded-full"></div>
    </div>

    <div class="grid md:grid-cols-3 gap-6">

      <!-- Alamat (klik Maps) -->
      <a
        href="https://www.google.com/maps/search/?api=1&query=Valeria+Coffee"
        target="_blank"
        rel="noopener"
        class="group bg-stone-800 p-6 rounded-2xl border border-stone-700 hover:border-orange-400 hover:bg-stone-800/80 transition"
      >
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 rounded-xl bg-orange-600/20 flex items-center justify-center text-2xl">📍</div>
          <div class="flex-1">
            <h3 class="font-bold text-lg">Alamat</h3>
            <p class="text-stone-300 mt-1 leading-relaxed">
              (Isi alamat kamu di sini)<br>
              Kota, Indonesia
            </p>
            <p class="text-sm text-orange-300 mt-3 group-hover:underline">Buka Google Maps →</p>
          </div>
        </div>
      </a>

      <!-- WhatsApp (klik chat) -->
      <a
        href="https://wa.me/6281234567890?text=Halo%20Valeria%20Coffee,%20saya%20mau%20tanya%20menu"
        target="_blank"
        rel="noopener"
        class="group bg-stone-800 p-6 rounded-2xl border border-stone-700 hover:border-green-400 hover:bg-stone-800/80 transition"
      >
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 rounded-xl bg-green-600/20 flex items-center justify-center text-2xl">📱</div>
          <div class="flex-1">
            <h3 class="font-bold text-lg">WhatsApp</h3>
            <p class="text-stone-300 mt-1">+62 812-3456-7890</p>
            <p class="text-sm text-green-300 mt-3 group-hover:underline">Chat sekarang →</p>
          </div>
        </div>
      </a>

      <!-- Instagram (klik profil) -->
      <a
        href="https://instagram.com/valeriacoffee"
        target="_blank"
        rel="noopener"
        class="group bg-stone-800 p-6 rounded-2xl border border-stone-700 hover:border-pink-400 hover:bg-stone-800/80 transition"
      >
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 rounded-xl bg-pink-600/20 flex items-center justify-center text-2xl">📷</div>
          <div class="flex-1">
            <h3 class="font-bold text-lg">Instagram</h3>
            <p class="text-stone-300 mt-1">@valeriacoffee</p>
            <p class="text-sm text-pink-300 mt-3 group-hover:underline">Lihat profil →</p>
          </div>
        </div>
      </a>

    </div>

    <div class="mt-14 text-center text-stone-400 text-sm">
      © {{ date('Y') }} Valeria Coffee. All Rights Reserved.
    </div>
  </div>
</section>

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

function getActionBox(id, scope) {
  return document.getElementById(`action-${scope}-${id}`);
}
function getQtyEl(id, scope) {
  return document.getElementById(`qty-${scope}-${id}`);
}

function renderQtyControls(id, scope, qty) {
  const box = getActionBox(id, scope);
  if (!box) return;

  if (qty <= 0) {
    if (scope === 'offer' || scope === 'bs') {
      box.innerHTML = `
        <button type="button" onclick="addFirst(${id}, '${scope}')"
          class="bg-green-600 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-lg shadow-green-100 hover:bg-stone-900 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
          </svg>
        </button>
      `;
    } else {
      box.innerHTML = `
        <button type="button" onclick="addFirst(${id}, '${scope}')"
          class="w-full bg-orange-600 text-white py-4 rounded-2xl font-bold hover:bg-stone-900 transition-all shadow-lg shadow-stone-200">
          + Tambah ke Pesanan
        </button>
      `;
    }
    return;
  }

  if (scope === 'offer' || scope === 'bs') {
    box.innerHTML = `
      <div class="flex items-center gap-3 bg-white px-3 py-2 rounded-2xl border border-orange-100">
        <button type="button" onclick="decreaseItem(${id}, '${scope}')"
          class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-stone-200 hover:bg-orange-500 hover:text-white transition-all font-bold">-</button>
        <span id="qty-${scope}-${id}" class="text-base font-bold min-w-5 text-center">${qty}</span>
        <button type="button" onclick="increaseItem(${id}, '${scope}')"
          class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-stone-200 hover:bg-orange-500 hover:text-white transition-all font-bold">+</button>
      </div>
    `;
    return;
  }

  box.innerHTML = `
    <div class="flex items-center gap-6 bg-stone-50 px-4 py-2 rounded-2xl border border-stone-100">
      <button type="button" onclick="decreaseItem(${id}, '${scope}')"
        class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-stone-200 text-stone-600 hover:bg-orange-500 hover:text-white transition-all font-bold shadow-sm">-</button>
      <span id="qty-${scope}-${id}" class="text-xl font-bold text-stone-800 min-w-5 text-center">${qty}</span>
      <button type="button" onclick="increaseItem(${id}, '${scope}')"
        class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-stone-200 text-stone-600 hover:bg-orange-500 hover:text-white transition-all font-bold shadow-sm">+</button>
    </div>
  `;
}

async function addFirst(id, scope) {
  renderQtyControls(id, scope, 1);
  try {
    await post(`/cart/add/${id}`);
  } catch (e) {
    renderQtyControls(id, scope, 0);
    alert('Gagal menambahkan pesanan. Coba lagi ya.');
  }
}

async function increaseItem(id, scope) {
  const el = getQtyEl(id, scope);
  const current = el ? parseInt(el.innerText || '0', 10) : 0;
  const next = current + 1;

  if (el) el.innerText = next;

  try {
    await post(`/cart/add/${id}`);
  } catch (e) {
    if (el) el.innerText = current;
    alert('Gagal menambah jumlah. Coba lagi ya.');
  }
}

async function decreaseItem(id, scope) {
  const el = getQtyEl(id, scope);
  const current = el ? parseInt(el.innerText || '0', 10) : 0;
  const next = current - 1;

  if (next <= 0) {
    renderQtyControls(id, scope, 0);
  } else {
    if (el) el.innerText = next;
  }

  try {
    await post(`/cart/decrease/${id}`);
  } catch (e) {
    renderQtyControls(id, scope, current);
    alert('Gagal mengurangi jumlah. Coba lagi ya.');
  }
}

/* =====================================================
   SINKRONISASI: jika item dihapus dari Cart (tab lain)
   maka tombol di welcome balik jadi "Tambah"
   (mengandalkan localStorage.cart_removed_id)
===================================================== */
function updateAllScopesToQty(id, qty) {
  ['offer', 'bs', 'cat'].forEach(scope => {
    const box = document.getElementById(`action-${scope}-${id}`);
    if (box) renderQtyControls(id, scope, qty);
  });
}

window.addEventListener('storage', (e) => {
  if (e.key === 'cart_removed_id' && e.newValue) {
    const id = parseInt(e.newValue, 10);
    if (!isNaN(id)) updateAllScopesToQty(id, 0);
  }
});

(function initialSync() {
  const removed = localStorage.getItem('cart_removed_id');
  if (removed) {
    const id = parseInt(removed, 10);
    if (!isNaN(id)) updateAllScopesToQty(id, 0);
    localStorage.removeItem('cart_removed_id');
  }
})();
</script>

</body>
</html>