@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Transaksi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">No.</th>
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">Jenis Sampah</th>
                            <th class="py-2">Berat</th>
                            <th class="py-2">Harga/Kg</th>
                            <th class="py-2">Total</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">QR Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                        <tr class="border-b">
                            <td class="py-2">#{{ $trx->id }}</td>
                            <td class="py-2">{{ $trx->created_at->format('d/m/Y') }}</td>
                            <td class="py-2">{{ $trx->wasteCategory->name }}</td>
                            <td class="py-2">{{ $trx->weight }} kg</td>
                            <td class="py-2">Rp {{ number_format($trx->price_per_kg, 0, ',', '.') }}</td>
                            <td class="py-2">Rp {{ number_format($trx->final_amount, 0, ',', '.') }}</td>
                            <td class="py-2">
                                <span class="px-2 py-1 text-xs rounded
                                    @if($trx->status === 'completed') bg-green-100 text-green-800
                                    @elseif($trx->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucwords($trx->status) }}
                                </span>
                            </td>
                            <td class="py-2">
                                @if($trx->qr_code_path)
                                    <object data="{{ Storage::url($trx->qr_code_path) }}" type="image/svg+xml" class="w-16 h-16">
                                        <a href="{{ Storage::url($trx->qr_code_path) }}" target="_blank" class="text-blue-600 text-xs">Lihat QR</a>
                                    </object>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-4 text-center text-gray-500">Belum ada transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>