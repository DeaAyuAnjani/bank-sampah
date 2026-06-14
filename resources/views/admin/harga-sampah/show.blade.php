<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Harga: {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Harga/Kg</th>
                            <th class="py-2">Berlaku Sejak</th>
                            <th class="py-2">Dicatat Pada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $item)
                        <tr class="border-b">
                            <td class="py-2">Rp {{ number_format($item->price_per_kg, 0, ',', '.') }}</td>
                            <td class="py-2">{{ $item->effective_date->format('d/m/Y') }}</td>
                            <td class="py-2">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    <a href="{{ route('admin.harga-sampah.index') }}"
                       class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>