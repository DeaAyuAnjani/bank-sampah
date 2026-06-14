<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function exportPdf(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $transactions = Transaction::with('user', 'wasteCategory')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->latest()
            ->get();

        $totalBerat = $transactions->sum('weight');
        $totalNilai = $transactions->sum('final_amount');
        $totalTransaksi = $transactions->count();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact(
            'transactions', 'totalBerat', 'totalNilai', 'totalTransaksi', 'bulan', 'tahun'
        ));

        return $pdf->download("laporan-transaksi-{$bulan}-{$tahun}.pdf");
    }

    public function exportExcel(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $transactions = Transaction::with('user', 'wasteCategory')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->latest()
            ->get();

        $filename = "laporan-transaksi-{$bulan}-{$tahun}.xlsx";

        return Excel::download(new class($transactions) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            protected $transactions;

            public function __construct($transactions)
            {
                $this->transactions = $transactions;
            }

            public function collection()
            {
                return $this->transactions->map(function ($trx) {
                    return [
                        $trx->id,
                        $trx->user->name,
                        $trx->wasteCategory->name,
                        $trx->weight . ' kg',
                        'Rp ' . number_format($trx->price_per_kg, 0, ',', '.'),
                        'Rp ' . number_format($trx->final_amount, 0, ',', '.'),
                        ucwords(str_replace('_', ' ', $trx->transaction_type)),
                        ucwords($trx->status),
                        $trx->created_at->format('d/m/Y'),
                    ];
                });
            }

            public function headings(): array
            {
                return ['ID', 'Nasabah', 'Jenis Sampah', 'Berat', 'Harga/Kg', 'Total', 'Tipe', 'Status', 'Tanggal'];
            }
        }, $filename);
    }
}