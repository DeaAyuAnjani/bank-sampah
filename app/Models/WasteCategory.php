<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteCategory extends Model
{
    protected $fillable = ['name', 'description', 'image'];

    public function prices()
    {
        return $this->hasMany(WastePrice::class);
    }

    public function latestPrice()
    {
        return $this->hasOne(WastePrice::class)->latestOfMany('effective_date');
    }

    public function pickupRequests()
    {
        return $this->hasMany(PickupRequest::class);
    }

    public function selfDeliveryRequests()
    {
        return $this->hasMany(SelfDeliveryRequest::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}