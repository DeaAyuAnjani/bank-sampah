<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Statistik Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Total Nasabah</div>
                    <div class="text-2xl font-bold">{{ $totalNasabah }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Total Transaksi</div>
                    <div class="text-2xl font-bold">{{ $totalTransaksi }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Total Berat Sampah</div>
                    <div class="text-2xl font-bold">{{ number_format($totalBerat, 2) }} kg</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Pendapatan</div>
                    <div class="text-2xl font-bold">Rp {{ number_format($pendapatan, 0, ',', '.') }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Pickup Belum Diproses</div>
                    <div class="text-2xl font-bold">{{ $pickupBelumDiproses }}</div>
                </div>
            </div>

            {{-- Grafik --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Transaksi per Bulan</h3>
                    <canvas id="chartTransaksi"></canvas>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Jenis Sampah Terbanyak</h3>
                    <canvas id="chartJenisSampah"></canvas>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Berat Sampah per Bulan (kg)</h3>
                    <canvas id="chartBerat"></canvas>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Nasabah Baru per Bulan</h3>
                    <canvas id="chartNasabah"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data dari controller
        const transaksiData = @json($chartTransaksi);
        const jenisSampahData = @json($chartJenisSampah);
        const beratData = @json($chartBerat);
        const nasabahData = @json($chartNasabah);

        // Grafik Transaksi per Bulan
        new Chart(document.getElementById('chartTransaksi'), {
            type: 'bar',
            data: {
                labels: transaksiData.map(d => d.bulan),
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: transaksiData.map(d => d.total),
                    backgroundColor: 'rgba(59, 130, 246, 0.6)',
                }]
            }
        });

        // Grafik Jenis Sampah
        new Chart(document.getElementById('chartJenisSampah'), {
            type: 'pie',
            data: {
                labels: jenisSampahData.map(d => d.nama),
                datasets: [{
                    data: jenisSampahData.map(d => d.total),
                    backgroundColor: [
                        '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#06B6D4'
                    ]
                }]
            }
        });

        // Grafik Berat per Bulan
        new Chart(document.getElementById('chartBerat'), {
            type: 'line',
            data: {
                labels: beratData.map(d => d.bulan),
                datasets: [{
                    label: 'Berat (kg)',
                    data: beratData.map(d => d.total),
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                }]
            }
        });

        // Grafik Nasabah Baru
        new Chart(document.getElementById('chartNasabah'), {
            type: 'bar',
            data: {
                labels: nasabahData.map(d => d.bulan),
                datasets: [{
                    label: 'Nasabah Baru',
                    data: nasabahData.map(d => d.total),
                    backgroundColor: 'rgba(139, 92, 246, 0.6)',
                }]
            }
        });
    </script>
</x-app-layout>