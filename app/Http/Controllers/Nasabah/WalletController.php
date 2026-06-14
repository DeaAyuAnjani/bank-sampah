<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $wallet = auth()->user()->wallet;

        $histories = WalletHistory::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('nasabah.wallet', compact('wallet', 'histories'));
    }

    public function withdraw(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $wallet = auth()->user()->wallet;

        if (!$wallet || $wallet->balance < $validated['amount']) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }

        $wallet->decrement('balance', $validated['amount']);

        WalletHistory::create([
            'user_id' => auth()->id(),
            'transaction_id' => null,
            'type' => 'penarikan',
            'amount' => $validated['amount'],
            'balance_after' => $wallet->fresh()->balance,
            'status' => 'pending',
            'notes' => 'Pengajuan penarikan saldo',
        ]);

        return back()->with('success', 'Pengajuan penarikan berhasil dikirim.');
    }
}