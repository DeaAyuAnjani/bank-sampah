<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Transaksi #{{ $transaksi->id }}
        </h2>
    </x-slot>

```
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-3">

            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <p><strong>Nasabah:</strong> {{ $transaksi->user->name }}</p>
            <p><strong>Email:</strong> {{ $transaksi->user->email }}</p>
            <p><strong>Jenis Sampah:</strong> {{ $transaksi->wasteCategory->name }}</p>
            <p><strong>Berat:</strong> {{ $transaksi->weight }} kg</p>
            <p><strong>Harga/Kg:</strong> Rp {{ number_format($transaksi->price_per_kg, 0, ',', '.') }}</p>
            <p><strong>Total Nilai:</strong> Rp {{ number_format($transaksi->total_price, 0, ',', '.') }}</p>
            <p><strong>Biaya Pickup:</strong> Rp {{ number_format($transaksi->pickup_fee, 0, ',', '.') }}</p>
            <p><strong>Total Diterima:</strong> Rp {{ number_format($transaksi->final_amount, 0, ',', '.') }}</p>
            <p><strong>Tipe:</strong> {{ ucwords(str_replace('_', ' ', $transaksi->transaction_type)) }}</p>

            <p>
                <strong>Status:</strong>
                <span class="px-2 py-1 text-xs rounded
                    @if($transaksi->status === 'completed') bg-green-100 text-green-800
                    @elseif($transaksi->status === 'rejected') bg-red-100 text-red-800
                    @elseif($transaksi->status === 'verified') bg-blue-100 text-blue-800
                    @else bg-yellow-100 text-yellow-800
                    @endif">
                    {{ ucwords($transaksi->status) }}
                </span>
            </p>

            <p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d/m/Y H:i') }}</p>

            <form action="{{ route('admin.transaksi.update', $transaksi->id) }}" method="POST" class="mt-4">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium mb-1">
                        Update Status
                    </label>

                    <select name="status"
                            class="w-full border rounded p-2"
                            {{ in_array($transaksi->status, ['completed', 'rejected']) ? 'disabled' : '' }}>
                        <option value="pending" {{ $transaksi->status === 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="verified" {{ $transaksi->status === 'verified' ? 'selected' : '' }}>
                            Verified
                        </option>

                        <option value="completed" {{ $transaksi->status === 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                        <option value="rejected" {{ $transaksi->status === 'rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>
                    </select>
                </div>

                @if(!in_array($transaksi->status, ['completed', 'rejected']))
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Update Status
                    </button>
                @else
                    <p class="text-gray-500 text-sm">
                        Transaksi ini sudah final ({{ ucwords($transaksi->status) }}) dan tidak dapat diubah.
                    </p>
                @endif
            </form>

            <div class="mt-4">
                <a href="{{ route('admin.transaksi.index') }}"
                   class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 inline-block">
                    Kembali
                </a>
            </div>

        </div>
    </div>
</div>
```

</x-app-layout>
