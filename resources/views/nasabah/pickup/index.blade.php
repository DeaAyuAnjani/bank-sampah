<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Pickup
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('nasabah.pickup.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                + Ajukan Pickup
            </a>

            <div class="bg-white mt-4 p-6 rounded shadow">

                <table class="w-full">
                    <thead>
                        <tr>
                            <th>Jenis Sampah</th>
                            <th>Berat</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pickups as $pickup)
                            <tr>
                                <td>{{ $pickup->wasteCategory->name }}</td>
                                <td>{{ $pickup->estimated_weight }} Kg</td>
                                <td>{{ $pickup->pickup_date }}</td>
                                <td>{{ ucfirst($pickup->status) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    Belum ada pengajuan pickup.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</x-app-layout>