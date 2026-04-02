<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Valeria Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-[#FDFBF7] min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-xl border border-stone-100 p-8">
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <h2 class="text-2xl font-bold text-[#3C2A21] text-center mb-6">Masuk Akun</h2>
                
                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-2">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border border-stone-200 outline-none focus:ring-2 focus:ring-[#3C2A21]">
                </div>

                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-stone-200 outline-none focus:ring-2 focus:ring-[#3C2A21]">
                </div>

                <button type="submit" class="w-full bg-[#3C2A21] text-white font-bold py-4 rounded-xl hover:bg-[#2A1D17] transition-all">
                    Masuk
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-stone-50 text-center">
                <p class="text-stone-600 text-sm">
                    Belum punya akun? 
                    <a href="{{ route('customer.register') }}" class="text-[#3C2A21] font-bold hover:underline">Daftar Akun Baru</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>