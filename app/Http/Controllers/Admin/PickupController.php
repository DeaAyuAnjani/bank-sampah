<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PickupRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PickupController extends Controller
{
    public function index()
    {
        $pickups = PickupRequest::with('user', 'wasteCategory')
            ->latest()
            ->paginate(10);

        return view('admin.pickup.index', compact('pickups'));
    }

    public function edit(PickupRequest $pickup)
    {
        return view('admin.pickup.edit', compact('pickup'));
    }

    public function update(Request $request, PickupRequest $pickup)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu_konfirmasi,dijadwalkan,dalam_perjalanan,selesai,ditolak',
        ]);

        $pickup->update($validated);

        if ($validated['status'] === 'selesai' && !$pickup->wasteCategory->latestPrice) {
            return redirect()->route('admin.pickup.index')
                ->with('error', 'Tidak bisa menyelesaikan: harga sampah untuk kategori ini belum diatur.');
        }

        if ($validated['status'] === 'selesai') {
            $price = $pickup->wasteCategory->latestPrice;
            $totalPrice = $pickup->estimated_weight * $price->price_per_kg;
            $finalAmount = $totalPrice - $pickup->pickup_fee;

            $trx = Transaction::create([
                'user_id' => $pickup->user_id,
                'waste_category_id' => $pickup->waste_category_id,
                'weight' => $pickup->estimated_weight,
                'price_per_kg' => $price->price_per_kg,
                'total_price' => $totalPrice,
                'pickup_fee' => $pickup->pickup_fee,
                'final_amount' => $finalAmount,
                'transaction_type' => 'pickup',
                'status' => 'completed',
            ]);

            // Update wallet otomatis
            $wallet = \App\Models\Wallet::firstOrCreate(
                ['user_id' => $pickup->user_id],
                ['balance' => 0, 'points' => 0]
            );
            $wallet->increment('balance', $finalAmount);
            $points = (int) floor($finalAmount / 1000);
            $wallet->increment('points', $points);

            \App\Models\WalletHistory::create([
                'user_id' => $pickup->user_id,
                'transaction_id' => $trx->id,
                'type' => 'masuk',
                'amount' => $finalAmount,
                'balance_after' => $wallet->fresh()->balance,
                'status' => 'approved',
            ]);

            if ($points > 0) {
                \App\Models\PointTransaction::create([
                    'user_id' => $pickup->user_id,
                    'transaction_id' => $trx->id,
                    'type' => 'earn',
                    'points' => $points,
                ]);
            }
        }

        return redirect()->route('admin.pickup.index')
            ->with('success', 'Status pickup berhasil diperbarui.');
    }

    public function destroy(PickupRequest $pickup)
    {
        $pickup->delete();

        return redirect()->route('admin.pickup.index')
            ->with('success', 'Permintaan pickup berhasil dihapus.');
    }
}