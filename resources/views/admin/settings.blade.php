<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pengaturan Sistem
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Nama Bank Sampah</label>
                        <input type="text" name="bank_name"
                               value="{{ old('bank_name', $setting->bank_name ?? '') }}"
                               class="w-full border rounded p-2" required>
                        @error('bank_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Alamat Bank Sampah</label>
                        <textarea name="bank_address" class="w-full border rounded p-2" rows="3">{{ old('bank_address', $setting->bank_address ?? '') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">No. WhatsApp Admin</label>
                        <input type="text" name="whatsapp_number"
                               value="{{ old('whatsapp_number', $setting->whatsapp_number ?? '') }}"
                               class="w-full border rounded p-2"
                               placeholder="Contoh: 6281234567890">
                        <p class="text-xs text-gray-400 mt-1">Format: 628xxxxxxxxx (tanpa + atau spasi)</p>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Tarif Pickup (Rp)</label>
                        <input type="number" name="pickup_fee"
                               value="{{ old('pickup_fee', $setting->pickup_fee ?? 0) }}"
                               class="w-full border rounded p-2" min="0" step="500">
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-medium mb-1">Latitude</label>
                            <input type="text" name="latitude"
                                   value="{{ old('latitude', $setting->latitude ?? '') }}"
                                   class="w-full border rounded p-2"
                                   placeholder="Contoh: -6.200000">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Longitude</label>
                            <input type="text" name="longitude"
                                   value="{{ old('longitude', $setting->longitude ?? '') }}"
                                   class="w-full border rounded p-2"
                                   placeholder="Contoh: 106.816666">
                        </div>
                    </div>

                    @if(($setting->latitude ?? null) && ($setting->longitude ?? null))
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Preview Lokasi</label>
                        <iframe
                            src="https://maps.google.com/maps?q={{ $setting->latitude }},{{ $setting->longitude }}&z=15&output=embed"
                            class="w-full h-48 rounded border"
                            allowfullscreen>
                        </iframe>
                    </div>
                    @endif

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Simpan Pengaturan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>