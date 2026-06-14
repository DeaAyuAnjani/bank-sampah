<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Harga Sampah
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Harga Sampah Terbaru</h3>
                    <a href="{{ route('admin.harga-sampah.create') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Tambah Harga
                    </a>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Jenis Sampah</th>
                            <th class="py-2">Harga/Kg</th>
                            <th class="py-2">Berlaku Sejak</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        @php $price = $latestPrices->get($category->id); @endphp
                        <tr class="border-b">
                            <td class="py-2">{{ $category->name }}</td>
                            <td class="py-2">
                                @if($price)
                                    Rp {{ number_format($price->price_per_kg, 0, ',', '.') }}
                                @else
                                    <span class="text-gray-400">Belum ada harga</span>
                                @endif
                            </td>
                            <td class="py-2">
                                {{ $price ? $price->effective_date->format('d/m/Y') : '-' }}
                            </td>
                            <td class="py-2 space-x-2">
                                @if($price)
                                    <a href="{{ route('admin.harga-sampah.show', $price->id) }}"
                                       class="text-green-600 hover:underline">Riwayat</a>
                                    <a href="{{ route('admin.harga-sampah.edit', $price->id) }}"
                                       class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.harga-sampah.destroy', $price->id) }}"
                                          method="POST" class="inline"
                                          onsubmit="return confirm('Hapus harga ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-500">Belum ada jenis sampah.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>