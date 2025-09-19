<x-filament::page>
    {{-- Statistik utama --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Penjualan</div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white">
                Rp {{ number_format($data['total_sales'], 0, ',', '.') }}
            </div>
            <div class="text-xs text-green-600 mt-1">Semua transaksi final</div>
        </div>
    
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Jumlah Transaksi</div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ $data['transaction_count'] }}
            </div>
            <div class="text-xs text-primary-600 mt-1">Order non-DRAFT</div>
        </div>
    </div>
    

    {{-- Statistik stok --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="text-sm text-gray-500">Stok Besar</div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($data['stok']->besar, 0) }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="text-sm text-gray-500">Stok Tengah</div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($data['stok']->tengah, 0) }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="text-sm text-gray-500">Stok Kecil</div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($data['stok']->kecil, 0) }}</div>
        </div>
    </div>    

    {{-- Grafik Penjualan --}}
    <x-filament::card class="mb-6">
        <h3 class="text-lg font-bold mb-4">Grafik Penjualan per Bulan</h3>
        <canvas id="salesChart"></canvas>
    </x-filament::card>

    {{-- Top Produk Terjual --}}
    <x-filament::card>
        <h3 class="text-lg font-bold mb-4">Top 5 Barang Terjual</h3>
        <ul class="list-disc pl-5 space-y-2">
            @foreach ($data['top_products'] as $product)
                <li>
                    ID Barang: <span class="font-semibold">{{ $product->id_barang }}</span><br>
                    Total Terjual: <span class="text-primary-600 font-bold">{{ number_format($product->total_qty, 0) }}</span>
                </li>
            @endforeach
        </ul>
    </x-filament::card>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($data['sales_per_month']->pluck('bulan')) !!},
                datasets: [{
                    label: 'Total Penjualan',
                    data: {!! json_encode($data['sales_per_month']->pluck('total')) !!},
                    backgroundColor: 'rgba(99, 102, 241, 0.6)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString()
                        }
                    }
                }
            }
        });
    </script>
</x-filament::page>
