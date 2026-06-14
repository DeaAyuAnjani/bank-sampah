<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\WasteCategory;
use App\Models\WastePrice;

class WastePriceController extends Controller
{
    public function index()
    {
        $latestPrices = WastePrice::with('wasteCategory')
            ->orderBy('effective_date', 'desc')
            ->get()
            ->groupBy('waste_category_id')
            ->map(fn ($group) => $group->first());

        $categories = WasteCategory::all();

        return view('nasabah.harga-sampah', compact('categories', 'latestPrices'));
    }
}