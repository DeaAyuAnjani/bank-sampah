<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Wallet Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            {{-- Saldo & Poin --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Saldo</p>
                    <p class="text-2xl font-bold text-green-600">
                        Rp {{ number_format($wallet->balance ?? 0, 0, ',', '.') }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Poin</p>
                    <p class="text-2xl font-bold text-blue-600">
                        {{ $wallet->points ?? 0 }} poin
                    </p>
                </div>
            </div>

            {{-- Form Penarikan --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-4">Ajukan Penarikan Saldo</h3>
                <form action="{{ route('nasabah.wallet.withdraw') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Jumlah Penarikan (min. Rp 10.000)</label>
                        <input type="number" name="amount" class="w-full border rounded p-2"
                               min="10000" step="1000" placeholder="Contoh: 50000">
                        @error('amount')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Ajukan Penarikan
                    </button>
                </form>
            </div>

            {{-- Riwayat Saldo --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-4">Riwayat Saldo</h3>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">Tipe</th>
                            <th class="py-2">Jumlah</th>
                            <th class="py-2">Saldo Setelah</th>
                            <th class="py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($histories as $history)
                        <tr class="border-b">
                            <td class="py-2">{{ $history->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-2">{{ ucwords($history->type) }}</td>
                            <td class="py-2">
                                <span class="{{ $history->type === 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $history->type === 'masuk' ? '+' : '-' }}
                                    Rp {{ number_format($history->amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="py-2">Rp {{ number_format($history->balance_after, 0, ',', '.') }}</td>
                            <td class="py-2">
                                <span class="px-2 py-1 text-xs rounded
                                    @if($history->status === 'approved') bg-green-100 text-green-800
                                    @elseif($history->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucwords($history->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-500">Belum ada riwayat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $histories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>