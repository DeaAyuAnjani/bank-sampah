<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\PickupRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalTransaksi = Transaction::where('user_id', $user->id)->count();
        $totalBerat = Transaction::where('user_id', $user->id)->sum('weight');
        $totalSaldo = $user->wallet->balance ?? 0;
        $pickupStatus = PickupRequest::where('user_id', $user->id)
            ->latest()
            ->first();

        return view('nasabah.dashboard', compact(
            'totalTransaksi', 'totalBerat', 'totalSaldo', 'pickupStatus'
        ));
    }
}