<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'bank_name', 'bank_address', 'latitude', 'longitude',
        'whatsapp_number', 'pickup_fee',
    ];
}