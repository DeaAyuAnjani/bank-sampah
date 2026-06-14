<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'waste_category_id', 'weight', 'price_per_kg',
        'total_price', 'pickup_fee', 'final_amount',
        'transaction_type', 'status', 'qr_code_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wasteCategory()
    {
        return $this->belongsTo(WasteCategory::class);
    }

    public function walletHistory()
    {
        return $this->hasOne(WalletHistory::class);
    }

    public function pointTransaction()
    {
        return $this->hasOne(PointTransaction::class);
    }
}