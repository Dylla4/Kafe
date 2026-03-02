<!DOCTYPE html>
<html>
<head>
    <title>Admin Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <h1 class="text-2xl font-bold mb-6">📦 Daftar Order</h1>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if(empty($orders))
        <div class="bg-white p-4 rounded shadow">
            Tidak ada order.
        </div>
    @else

        <div class="space-y-4">

        @foreach($orders as $id => $order)

            @php
                // status dari firebase kadang bisa array/object → amankan jadi string
                $rawStatus = $order['status'] ?? 'diproses';
                $status = is_string($rawStatus) ? $rawStatus : 'diproses';

                $badgeClass = match ($status) {
                    'pending'  => 'bg-yellow-500',
                    'diproses' => 'bg-blue-500',
                    'selesai'  => 'bg-green-600',
                    default    => 'bg-gray-500',
                };
            @endphp

            <div class="bg-white p-4 rounded shadow">

                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-lg">
                            Order ID: {{ $id }}
                        </h2>

                        <p class="text-sm text-gray-600">
                            Nama: {{ $order['nama'] ?? ($order['nama_pembeli'] ?? '-') }}
                        </p>

                        <p class="text-sm text-gray-600">
                            Total: Rp {{ number_format($order['total'] ?? ($order['total_harga'] ?? 0)) }}
                        </p>
                    </div>

                    {{-- STATUS BADGE --}}
                    <span class="px-3 py-1 rounded text-white text-sm {{ $badgeClass }}">
                        {{ ucfirst((string) $status) }}
                    </span>
                </div>

                {{-- Dropdown Update Status --}}
                <div class="mt-4">
                    <form action="{{ url('/orders/'.$id.'/status') }}" method="POST">
                        @csrf

                        <label class="text-sm font-semibold">Ubah Status:</label>

                        <select name="status"
                                onchange="this.form.submit()"
                                class="border rounded px-3 py-1 ml-2">

                            <option value="proses" {{ $status === 'proses' ? 'selected' : '' }}>
                                Diproses
                            </option>

                            <option value="siap" {{ $status === 'siap' ? 'selected' : '' }}>
                                Siap
                            </option>

                            <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                        </select>
                    </form>
                </div>

            </div>

        @endforeach

        </div>

    @endif

</body>
</html>