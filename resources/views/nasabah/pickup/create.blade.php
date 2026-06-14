<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajukan Pickup Sampah
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow">

                <form action="{{ route('nasabah.pickup.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label>Jenis Sampah</label>
                        <select name="waste_category_id" class="w-full border rounded p-2">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label>Perkiraan Berat (Kg)</label>
                        <input type="number"
                               step="0.01"
                               name="estimated_weight"
                               class="w-full border rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label>Tanggal Pickup</label>
                        <input type="date"
                               name="pickup_date"
                               class="w-full border rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label>Alamat Pickup</label>
                        <textarea name="address"
                                  class="w-full border rounded p-2"
                                  rows="3"></textarea>
                    </div>

                    <div class="mb-4">
                        <label>Catatan</label>
                        <textarea name="notes"
                                  class="w-full border rounded p-2"
                                  rows="3"></textarea>
                    </div>

                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded">
                        Kirim Permintaan
                    </button>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>