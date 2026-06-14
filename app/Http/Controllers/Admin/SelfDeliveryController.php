<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SelfDeliveryRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class SelfDeliveryController extends Controller
{
    public function index()
    {
        $deliveries = SelfDeliveryRequest::with('user', 'wasteCategory')
            ->latest()
            ->paginate(10);
        return view('admin.antar-sendiri.index', compact('deliveries'));
    }

    public function show(SelfDeliveryRequest $antar_sendiri)
    {
        return view('admin.antar-sendiri.show', ['delivery' => $antar_sendiri]);
    }

    public function update(Request $request, SelfDeliveryRequest $antar_sendiri)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu_verifikasi,diverifikasi,ditolak',
        ]);

        if ($validated['status'] === 'diverifikasi') {
            $price = $antar_sendiri->wasteCategory->latestPrice;
            if (!$price) {
                return back()->with('error', 'Harga sampah untuk jenis ini belum diatur.');
            }

            $totalPrice = $antar_sendiri->weight * $price->price_per_kg;

            $trx = Transaction::create([
                'user_id' => $antar_sendiri->user_id,
                'waste_category_id' => $antar_sendiri->waste_category_id,
                'weight' => $antar_sendiri->weight,
                'price_per_kg' => $price->price_per_kg,
                'total_price' => $totalPrice,
                'pickup_fee' => 0,
                'final_amount' => $totalPrice,
                'transaction_type' => 'antar_sendiri',
                'status' => 'completed',
            ]);

            // Update wallet otomatis
            $wallet = \App\Models\Wallet::firstOrCreate(
                ['user_id' => $antar_sendiri->user_id],
                ['balance' => 0, 'points' => 0]
            );
            $wallet->increment('balance', $totalPrice);
            $points = (int) floor($totalPrice / 1000);
            $wallet->increment('points', $points);

            // Generate QR Code
            $qrData = "TRX#{$trx->id}|{$antar_sendiri->user->name}|{$antar_sendiri->wasteCategory->name}|{$antar_sendiri->weight}kg|Rp{$totalPrice}";
            $qrPath = "qrcodes/trx-{$trx->id}.svg";
            $renderer = new ImageRenderer(new RendererStyle(300), new SvgImageBackEnd());
            $writer = new Writer($renderer);
            $writer->writeFile($qrData, storage_path("app/public/{$qrPath}"));
            $trx->update(['qr_code_path' => $qrPath]);

            \App\Models\WalletHistory::create([
                'user_id' => $antar_sendiri->user_id,
                'transaction_id' => $trx->id,
                'type' => 'masuk',
                'amount' => $totalPrice,
                'balance_after' => $wallet->fresh()->balance,
                'status' => 'approved',
            ]);

            if ($points > 0) {
                \App\Models\PointTransaction::create([
                    'user_id' => $antar_sendiri->user_id,
                    'transaction_id' => $trx->id,
                    'type' => 'earn',
                    'points' => $points,
                ]);
            }
        }

        $antar_sendiri->update($validated);

        return redirect()->route('admin.antar-sendiri.index')
            ->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}