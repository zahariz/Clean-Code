<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Demo - Order List Dashboard (Dirty Code)</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Daftar Pesanan Toko Online</h1>
                <p class="text-sm text-gray-500">Live Demo: Simulasi N+1 Query & Clean Code Refactoring</p>
            </div>
            <a href="?promo=FLASHSALE" class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded hover:bg-indigo-700">
                Gunakan Promo FLASHSALE
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 text-sm">
                        <th class="p-3 border">ID Order</th>
                        <th class="p-3 border">Nama Pembeli</th>
                        <th class="p-3 border">Jumlah Item</th>
                        <th class="p-3 border">Total Bayar</th>
                        <th class="p-3 border">Status Badge</th>
                        <th class="p-3 border">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($d as $item)
                        <tr class="border-b hover:bg-gray-50 text-sm">
                            <td class="p-3 font-semibold text-gray-700">#ORD-{{ $item['id'] }}</td>
                            <td class="p-3 text-gray-800">{{ $item['customer'] }}</td>
                            <td class="p-3 text-gray-600">{{ $item['items_count'] }} Item</td>
                            <td class="p-3 font-bold text-emerald-600">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                            <td class="p-3">{!! $item['badge'] !!}</td>
                            <td class="p-3 text-gray-500 text-xs">{{ $item['created_at'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
