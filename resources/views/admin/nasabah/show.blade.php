<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Nasabah: {{ $nasabah->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-2">Informasi Nasabah</h3>
                <p><strong>Nama:</strong> {{ $nasabah->name }}</p>
                <p><strong>Email:</strong> {{ $nasabah->email }}</p>
                <p><strong>No. WhatsApp:</strong> {{ $nasabah->phone ?? '-' }}</p>
                <p><strong>Alamat:</strong> {{ $nasabah->address ?? '-' }}</p>
                <p><strong>Saldo:</strong> Rp {{ number_format($nasabah->wallet->balance ?? 0, 0, ',', '.') }}</p>
                <p><strong>Poin:</strong> {{ $nasabah->wallet->points ?? 0 }}</p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-2">Riwayat Transaksi</h3>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Jenis Sampah</th>
                            <th class="py-2">Berat</th>
                            <th class="py-2">Total</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nasabah->transactions as $trx)
                        <tr class="border-b">
                            <td class="py-2">{{ $trx->wasteCategory->name }}</td>
                            <td class="py-2">{{ $trx->weight }} kg</td>
                            <td class="py-2">Rp {{ number_format($trx->final_amount, 0, ',', '.') }}</td>
                            <td class="py-2">{{ ucwords($trx->status) }}</td>
                            <td class="py-2">{{ $trx->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="py-4 text-center text-gray-500">Belum ada transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <a href="{{ route('admin.nasabah.index') }}"
               class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 inline-block">
                Kembali
            </a>
        </div>
    </div>
</x-app-layout>