<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionHistoryController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('wasteCategory')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('nasabah.riwayat', compact('transactions'));
    }
}