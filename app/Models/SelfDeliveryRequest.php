<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelfDeliveryRequest extends Model
{
    protected $fillable = [
        'user_id', 'waste_category_id', 'weight',
        'scale_photo', 'delivery_date', 'status', 'notes',
    ];

    protected $casts = [
        'delivery_date' => 'date',
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