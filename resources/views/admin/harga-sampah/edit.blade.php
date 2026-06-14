<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Harga Sampah
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.harga-sampah.update', $price->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Jenis Sampah</label>
                        <select name="waste_category_id" class="w-full border rounded p-2" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('waste_category_id', $price->waste_category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('waste_category_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Harga per Kg (Rp)</label>
                        <input type="number" name="price_per_kg" value="{{ old('price_per_kg', $price->price_per_kg) }}"
                               class="w-full border rounded p-2" min="0" step="100" required>
                        @error('price_per_kg')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Berlaku Sejak</label>
                        <input type="date" name="effective_date" value="{{ old('effective_date', $price->effective_date->format('Y-m-d')) }}"
                               class="w-full border rounded p-2" required>
                        @error('effective_date')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Update
                        </button>
                        <a href="{{ route('admin.harga-sampah.index') }}"
                           class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>