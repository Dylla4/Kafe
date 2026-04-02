<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#FDFBF7] min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-[#3C2A21] tracking-tight">VALERIA <span class="text-amber-700">COFFEE</span></h1>
            <p class="text-stone-500 mt-2">Buat akun untuk mulai memesan</p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-stone-100 p-8">
            <form action="{{ route('customer.register') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 outline-none focus:ring-2 focus:ring-[#3C2A21] transition-all">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 outline-none focus:ring-2 focus:ring-[#3C2A21] transition-all">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-2">Password</label>
                    <input type="password" name="password" required 
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 outline-none focus:ring-2 focus:ring-[#3C2A21] transition-all">
                </div>

                <button type="submit" class="w-full bg-[#3C2A21] text-white font-bold py-4 rounded-xl hover:bg-[#2A1D17] transition-all shadow-lg shadow-stone-200">
                    Daftar Sekarang
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-stone-50 text-center">
                <p class="text-stone-600 text-sm">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-[#3C2A21] font-bold hover:underline">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>