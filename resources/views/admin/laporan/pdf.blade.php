<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        p { text-align: center; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .summary { margin: 15px 0; }
        .summary span { margin-right: 20px; }
    </style>
</head>
<body>
    <h2>Laporan Transaksi Bank Sampah</h2>
    <p>Periode: {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->format('F Y') }}</p>
    <p>Dicetak: {{ now()->format('d/m/Y H:i') }}</p>

    <div class="summary" style="margin-top:15px;">
        <span><strong>Total Transaksi:</strong> {{ $totalTransaksi }}</span>
        <span><strong>Total Berat:</strong> {{ number_format($totalBerat, 2) }} kg</span>
        <span><strong>Total Nilai:</strong> Rp {{ number_format($totalNilai, 0, ',', '.') }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nasabah</th>
                <th>Jenis Sampah</th>
                <th>Berat</th>
                <th>Harga/Kg</th>
                <th>Total</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $i => $trx)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $trx->user->name }}</td>
                <td>{{ $trx->wasteCategory->name }}</td>
                <td>{{ $trx->weight }} kg</td>
                <td>Rp {{ number_format($trx->price_per_kg, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($trx->final_amount, 0, ',', '.') }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $trx->transaction_type)) }}</td>
                <td>{{ ucwords($trx->status) }}</td>
                <td>{{ $trx->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>