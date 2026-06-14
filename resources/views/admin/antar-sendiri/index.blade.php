@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verifikasi Antar Sendiri
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Nasabah</th>
                            <th class="py-2">Jenis Sampah</th>
                            <th class="py-2">Berat</th>
                            <th class="py-2">Foto</th>
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deliveries as $delivery)
                        <tr class="border-b">
                            <td class="py-2">{{ $delivery->user->name }}</td>
                            <td class="py-2">{{ $delivery->wasteCategory->name }}</td>
                            <td class="py-2">{{ $delivery->weight }} kg</td>
                            <td class="py-2">
                                <a href="{{ Storage::url($delivery->scale_photo) }}" target="_blank">
                                    <img src="{{ Storage::url($delivery->scale_photo) }}" class="w-12 h-12 object-cover rounded">
                                </a>
                            </td>
                            <td class="py-2">{{ $delivery->delivery_date->format('d/m/Y') }}</td>
                            <td class="py-2">
                                <span class="px-2 py-1 text-xs rounded
                                    @if($delivery->status === 'diverifikasi') bg-green-100 text-green-800
                                    @elseif($delivery->status === 'ditolak') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucwords(str_replace('_', ' ', $delivery->status)) }}
                                </span>
                            </td>
                            <td class="py-2">
                                @if($delivery->status === 'menunggu_verifikasi')
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.antar-sendiri.update', $delivery->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="diverifikasi">
                                        <button type="submit" class="text-green-600 hover:underline">Verifikasi</button>
                                    </form>
                                    <form action="{{ route('admin.antar-sendiri.update', $delivery->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="ditolak">
                                        <button type="submit" class="text-red-600 hover:underline">Tolak</button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-gray-500">Belum ada pengajuan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $deliveries->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>