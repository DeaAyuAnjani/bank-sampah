<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Update Status Pickup
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-4 space-y-1 text-sm text-gray-600">
                    <p><strong>Nasabah:</strong> {{ $pickup->user->name }}</p>
                    <p><strong>Jenis Sampah:</strong> {{ $pickup->wasteCategory->name }}</p>
                    <p><strong>Estimasi Berat:</strong> {{ $pickup->estimated_weight }} kg</p>
                    <p><strong>Alamat:</strong> {{ $pickup->pickup_address }}</p>
                    <p><strong>Tanggal:</strong> {{ $pickup->pickup_date->format('d/m/Y') }}</p>
                    <p><strong>Catatan:</strong> {{ $pickup->notes ?? '-' }}</p>
                </div>

                <form action="{{ route('admin.pickup.update', $pickup->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Status</label>
                        <select name="status" class="w-full border rounded p-2" required>
                            @foreach(['menunggu_konfirmasi', 'dijadwalkan', 'dalam_perjalanan', 'selesai', 'ditolak'] as $status)
                                <option value="{{ $status }}" {{ $pickup->status === $status ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if(!$pickup->wasteCategory->latestPrice)
                        <p class="text-yellow-600 text-sm mb-4">
                            ⚠ Harga untuk jenis sampah ini belum diatur. Status "Selesai" tidak akan bisa disimpan sampai harga diatur.
                        </p>
                    @endif

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Update
                        </button>
                        <a href="{{ route('admin.pickup.index') }}"
                           class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>