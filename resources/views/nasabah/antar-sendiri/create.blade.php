<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajukan Antar Sendiri
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('nasabah.antar-sendiri.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Jenis Sampah</label>
                        <select name="waste_category_id" class="w-full border rounded p-2" required>
                            <option value="">-- Pilih Jenis Sampah --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('waste_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('waste_category_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Berat Sampah (kg)</label>
                        <input type="number" step="0.01" name="weight" value="{{ old('weight') }}"
                               class="w-full border rounded p-2" min="0.1" required>
                        @error('weight')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Foto Bukti Timbangan</label>
                        <input type="file" name="scale_photo" accept="image/*" class="w-full border rounded p-2" required>
                        <p class="text-xs text-gray-400 mt-1">Format JPG/PNG, maksimal 5MB</p>
                        @error('scale_photo')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Tanggal Pengantaran</label>
                        <input type="date" name="delivery_date" value="{{ old('delivery_date', date('Y-m-d')) }}"
                               class="w-full border rounded p-2" required>
                        @error('delivery_date')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Catatan</label>
                        <textarea name="notes" class="w-full border rounded p-2" rows="3">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Kirim Pengajuan
                        </button>
                        <a href="{{ route('nasabah.antar-sendiri.index') }}"
                           class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>