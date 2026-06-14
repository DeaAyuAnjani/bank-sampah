@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Harga Sampah Terbaru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($categories as $category)
                    @php $price = $latestPrices->get($category->id); @endphp
                    <div class="border rounded-lg p-4 flex gap-4">
                        @if($category->image)
                            <img src="{{ Storage::url($category->image) }}"
                                 class="w-16 h-16 object-cover rounded">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs">
                                No Image
                            </div>
                        @endif
                        <div>
                            <h3 class="font-semibold">{{ $category->name }}</h3>
                            @if($price)
                                <p class="text-green-600 font-bold">
                                    Rp {{ number_format($price->price_per_kg, 0, ',', '.') }}/kg
                                </p>
                                <p class="text-xs text-gray-400">
                                    Berlaku sejak {{ $price->effective_date->format('d/m/Y') }}
                                </p>
                            @else
                                <p class="text-gray-400 text-sm">Harga belum tersedia</p>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500">Belum ada data jenis sampah.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>