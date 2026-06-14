<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WastePrice extends Model
{
    protected $fillable = ['waste_category_id', 'price_per_kg', 'effective_date'];

    protected $casts = [
        'effective_date' => 'date',
        'price_per_kg' => 'decimal:2',
    ];

    public function wasteCategory()
    {
        return $this->belongsTo(WasteCategory::class);
    }
}