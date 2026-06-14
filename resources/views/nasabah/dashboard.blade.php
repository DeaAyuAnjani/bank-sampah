<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Nasabah
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Total Transaksi</div>
                    <div class="text-2xl font-bold">{{ $totalTransaksi }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Total Berat Terjual</div>
                    <div class="text-2xl font-bold">{{ number_format($totalBerat, 2) }} kg</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Saldo</div>
                    <div class="text-2xl font-bold">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</div>
                </div>
            </div>

            @if($pickupStatus)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-sm text-gray-500 mb-2">Status Pickup Terakhir</div>
                <div class="text-lg font-semibold">{{ ucwords(str_replace('_', ' ', $pickupStatus->status)) }}</div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>