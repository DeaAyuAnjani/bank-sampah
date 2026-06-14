<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Pickup
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Daftar Permintaan Pickup</h3>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Nasabah</th>
                            <th class="py-2">Jenis Sampah</th>
                            <th class="py-2">Estimasi Berat</th>
                            <th class="py-2">Alamat</th>
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pickups as $pickup)
                        <tr class="border-b">
                            <td class="py-2">{{ $pickup->user->name }}</td>
                            <td class="py-2">{{ $pickup->wasteCategory->name }}</td>
                            <td class="py-2">{{ $pickup->estimated_weight }} kg</td>
                            <td class="py-2">{{ $pickup->pickup_address }}</td>
                            <td class="py-2">{{ $pickup->pickup_date->format('d/m/Y') }}</td>
                            <td class="py-2">
                                <span class="px-2 py-1 text-xs rounded
                                    @if($pickup->status === 'selesai') bg-green-100 text-green-800
                                    @elseif($pickup->status === 'ditolak') bg-red-100 text-red-800
                                    @elseif($pickup->status === 'menunggu_konfirmasi') bg-yellow-100 text-yellow-800
                                    @else bg-blue-100 text-blue-800
                                    @endif">
                                    {{ ucwords(str_replace('_', ' ', $pickup->status)) }}
                                </span>
                            </td>
                            <td class="py-2 space-x-2">
                                <a href="{{ route('admin.pickup.edit', $pickup->id) }}"
                                   class="text-blue-600 hover:underline">Update Status</a>
                                <form action="{{ route('admin.pickup.destroy', $pickup->id) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Hapus permintaan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-gray-500">Belum ada permintaan pickup.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $pickups->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>