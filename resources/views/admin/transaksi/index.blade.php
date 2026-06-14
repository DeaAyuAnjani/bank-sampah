<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Transaksi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">No.</th>
                            <th class="py-2">Nasabah</th>
                            <th class="py-2">Jenis Sampah</th>
                            <th class="py-2">Berat</th>
                            <th class="py-2">Total</th>
                            <th class="py-2">Tipe</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                        <tr class="border-b">
                            <td class="py-2">#{{ $trx->id }}</td>
                            <td class="py-2">{{ $trx->user->name }}</td>
                            <td class="py-2">{{ $trx->wasteCategory->name }}</td>
                            <td class="py-2">{{ $trx->weight }} kg</td>
                            <td class="py-2">Rp {{ number_format($trx->final_amount, 0, ',', '.') }}</td>
                            <td class="py-2">{{ ucwords(str_replace('_', ' ', $trx->transaction_type)) }}</td>
                            <td class="py-2">
                                <span class="px-2 py-1 text-xs rounded
                                    @if($trx->status === 'completed') bg-green-100 text-green-800
                                    @elseif($trx->status === 'rejected') bg-red-100 text-red-800
                                    @elseif($trx->status === 'verified') bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucwords($trx->status) }}
                                </span>
                            </td>
                            <td class="py-2">{{ $trx->created_at->format('d/m/Y') }}</td>
                            <td class="py-2 space-x-2">
                                <a href="{{ route('admin.transaksi.show', $trx->id) }}"
                                   class="text-green-600 hover:underline">Detail</a>
                                <form action="{{ route('admin.transaksi.destroy', $trx->id) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Hapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="py-4 text-center text-gray-500">Belum ada transaksi.</td>
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