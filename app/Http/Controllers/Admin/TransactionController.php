<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\WalletHistory;
use App\Models\PointTransaction;
use Illuminate\Http\Request;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user', 'wasteCategory')
            ->latest()
            ->paginate(10);

        return view('admin.transaksi.index', compact('transactions'));
    }

    public function show(Transaction $transaksi)
    {
        $transaksi->load('user', 'wasteCategory');
        return view('admin.transaksi.show', ['transaksi' => $transaksi]);
    }

    public function update(Request $request, Transaction $transaksi)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,verified,completed,rejected',
        ]);

        $oldStatus = $transaksi->status;
        $transaksi->update($validated);

        if ($validated['status'] === 'completed' && $oldStatus !== 'completed') {
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $transaksi->user_id],
                ['balance' => 0, 'points' => 0]
            );

            $wallet->increment('balance', $transaksi->final_amount);

            $points = (int) floor($transaksi->final_amount / 1000);
            $wallet->increment('points', $points);

            // Generate QR Code
            $qrData = "TRX#{$transaksi->id}|{$transaksi->user->name}|{$transaksi->wasteCategory->name}|{$transaksi->weight}kg|Rp{$transaksi->final_amount}";
            $qrPath = "qrcodes/trx-{$transaksi->id}.svg";
            $renderer = new ImageRenderer(new RendererStyle(300), new SvgImageBackEnd());
            $writer = new Writer($renderer);
            $writer->writeFile($qrData, storage_path("app/public/{$qrPath}"));
            $transaksi->update(['qr_code_path' => $qrPath]);

            WalletHistory::create([
                'user_id' => $transaksi->user_id,
                'transaction_id' => $transaksi->id,
                'type' => 'masuk',
                'amount' => $transaksi->final_amount,
                'balance_after' => $wallet->fresh()->balance,
                'status' => 'approved',
            ]);

            if ($points > 0) {
                PointTransaction::create([
                    'user_id' => $transaksi->user_id,
                    'transaction_id' => $transaksi->id,
                    'type' => 'earn',
                    'points' => $points,
                ]);
            }
        }

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Status transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaksi)
    {
        $transaksi->delete();

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}