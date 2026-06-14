<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PickupRequest extends Model
{
    protected $fillable = [
        'user_id',
        'waste_category_id',
        'estimated_weight',
        'pickup_date',
        'pickup_address',
        'pickup_fee',
        'notes',
        'status',
    ];

    protected $casts = [
        'pickup_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wasteCategory()
    {
        return $this->belongsTo(WasteCategory::class);
    }
}