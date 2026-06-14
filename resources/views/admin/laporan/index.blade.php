<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Export Laporan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-4">Pilih Periode</h3>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block font-medium mb-1">Bulan</label>
                        <select id="bulan" class="w-full border rounded p-2">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::createFromDate(now()->year, $i, 1)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Tahun</label>
                        <select id="tahun" class="w-full border rounded p-2">
                            @for($y = now()->year; $y >= now()->year - 3; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button onclick="exportLaporan('pdf')"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Export PDF
                    </button>
                    <button onclick="exportLaporan('excel')"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Export Excel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function exportLaporan(type) {
            const bulan = document.getElementById('bulan').value;
            const tahun = document.getElementById('tahun').value;
            const url = type === 'pdf'
                ? `{{ route('admin.laporan.pdf') }}?bulan=${bulan}&tahun=${tahun}`
                : `{{ route('admin.laporan.excel') }}?bulan=${bulan}&tahun=${tahun}`;
            window.location.href = url;
        }
    </script>
</x-app-layout>