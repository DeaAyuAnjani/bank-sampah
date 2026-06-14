<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\PickupRequest;
use App\Models\WasteCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalNasabah = User::where('role', 'nasabah')->count();
        $totalTransaksi = Transaction::count();
        $totalBerat = Transaction::sum('weight');
        $pendapatan = Transaction::where('status', 'completed')->sum('final_amount');
        $pickupBelumDiproses = PickupRequest::where('status', 'menunggu_konfirmasi')->count();

        // Grafik transaksi per bulan (12 bulan terakhir)
        $chartTransaksi = Transaction::select(
                DB::raw('MONTH(created_at) as bulan_num'),
                DB::raw('MONTHNAME(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan_num', 'bulan')
            ->orderBy('bulan_num')
            ->get();

        // Grafik jenis sampah terbanyak
        $chartJenisSampah = Transaction::select(
                'waste_category_id',
                DB::raw('SUM(weight) as total')
            )
            ->with('wasteCategory')
            ->groupBy('waste_category_id')
            ->get()
            ->map(fn($t) => [
                'nama' => $t->wasteCategory->name,
                'total' => $t->total,
            ]);

        // Grafik berat per bulan
        $chartBerat = Transaction::select(
                DB::raw('MONTH(created_at) as bulan_num'),
                DB::raw('MONTHNAME(created_at) as bulan'),
                DB::raw('SUM(weight) as total')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan_num', 'bulan')
            ->orderBy('bulan_num')
            ->get();

        // Grafik nasabah baru per bulan
        $chartNasabah = User::select(
                DB::raw('MONTH(created_at) as bulan_num'),
                DB::raw('MONTHNAME(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->where('role', 'nasabah')
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan_num', 'bulan')
            ->orderBy('bulan_num')
            ->get();

        return view('admin.dashboard', compact(
            'totalNasabah', 'totalTransaksi', 'totalBerat', 'pendapatan', 'pickupBelumDiproses',
            'chartTransaksi', 'chartJenisSampah', 'chartBerat', 'chartNasabah'
        ));
    }
}