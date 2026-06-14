@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Jenis Sampah
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
                    <h3 class="text-lg font-semibold">Daftar Jenis Sampah</h3>
                    <a href="{{ route('admin.jenis-sampah.create') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Tambah Jenis Sampah
                    </a>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Foto</th>
                            <th class="py-2">Nama</th>
                            <th class="py-2">Deskripsi</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr class="border-b">
                            <td class="py-2">
                                @if($category->image)
                                    <img src="{{ Storage::url($category->image) }}" class="w-12 h-12 object-cover rounded">
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="py-2">{{ $category->name }}</td>
                            <td class="py-2">{{ $category->description ?? '-' }}</td>
                            <td class="py-2 space-x-2">
                                <a href="{{ route('admin.jenis-sampah.edit', $category->id) }}"
                                   class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.jenis-sampah.destroy', $category->id) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Hapus jenis sampah ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-500">Belum ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>