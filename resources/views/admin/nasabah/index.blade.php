<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Nasabah
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
                    <h3 class="text-lg font-semibold">Daftar Nasabah</h3>
                    <a href="{{ route('admin.nasabah.create') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Tambah Nasabah
                    </a>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Nama</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">No. WhatsApp</th>
                            <th class="py-2">Total Transaksi</th>
                            <th class="py-2">Tgl Registrasi</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nasabahs as $nasabah)
                        <tr class="border-b">
                            <td class="py-2">{{ $nasabah->name }}</td>
                            <td class="py-2">{{ $nasabah->email }}</td>
                            <td class="py-2">{{ $nasabah->phone ?? '-' }}</td>
                            <td class="py-2">{{ $nasabah->transactions_count }}</td>
                            <td class="py-2">{{ $nasabah->created_at->format('d/m/Y') }}</td>
                            <td class="py-2 space-x-2">
                                <a href="{{ route('admin.nasabah.show', $nasabah->id) }}"
                                   class="text-green-600 hover:underline">Detail</a>
                                <a href="{{ route('admin.nasabah.edit', $nasabah->id) }}"
                                   class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.nasabah.destroy', $nasabah->id) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Hapus nasabah ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-gray-500">Belum ada nasabah.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $nasabahs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>