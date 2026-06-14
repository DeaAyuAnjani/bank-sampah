@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pengajuan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-2">
                <p><strong>Jenis Sampah:</strong> {{ $delivery->wasteCategory->name }}</p>
                <p><strong>Berat:</strong> {{ $delivery->weight }} kg</p>
                <p><strong>Tanggal:</strong> {{ $delivery->delivery_date->format('d/m/Y') }}</p>
                <p><strong>Status:</strong> {{ ucwords(str_replace('_', ' ', $delivery->status)) }}</p>
                <p><strong>Catatan:</strong> {{ $delivery->notes ?? '-' }}</p>
                <div>
                    <strong>Foto Timbangan:</strong><br>
                    <img src="{{ Storage::url($delivery->scale_photo) }}" class="w-64 mt-2 rounded">
                </div>

                <a href="{{ route('nasabah.antar-sendiri.index') }}"
                   class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 inline-block mt-4">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>