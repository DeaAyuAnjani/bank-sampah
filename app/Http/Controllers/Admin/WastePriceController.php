<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WastePrice;
use App\Models\WasteCategory;
use Illuminate\Http\Request;

class WastePriceController extends Controller
{
    public function index()
    {
        $categories = WasteCategory::with('prices' )->get();

        // Ambil harga terbaru per kategori
        $latestPrices = WastePrice::with('wasteCategory')
            ->orderBy('effective_date', 'desc')
            ->get()
            ->groupBy('waste_category_id')
            ->map(fn ($group) => $group->first());

        return view('admin.harga-sampah.index', compact('categories', 'latestPrices'));
    }

    public function create()
    {
        $categories = WasteCategory::all();
        return view('admin.harga-sampah.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'waste_category_id' => 'required|exists:waste_categories,id',
            'price_per_kg' => 'required|numeric|min:0',
            'effective_date' => 'required|date',
        ]);

        WastePrice::create($validated);

        return redirect()->route('admin.harga-sampah.index')
            ->with('success', 'Harga sampah berhasil ditambahkan.');
    }

    public function show(WastePrice $harga_sampah)
    {
        // Riwayat harga untuk kategori tertentu
        $history = WastePrice::where('waste_category_id', $harga_sampah->waste_category_id)
            ->orderBy('effective_date', 'desc')
            ->get();

        return view('admin.harga-sampah.show', [
            'category' => $harga_sampah->wasteCategory,
            'history' => $history,
        ]);
    }

    public function edit(WastePrice $harga_sampah)
    {
        $categories = WasteCategory::all();
        return view('admin.harga-sampah.edit', [
            'price' => $harga_sampah,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, WastePrice $harga_sampah)
    {
        $validated = $request->validate([
            'waste_category_id' => 'required|exists:waste_categories,id',
            'price_per_kg' => 'required|numeric|min:0',
            'effective_date' => 'required|date',
        ]);

        $harga_sampah->update($validated);

        return redirect()->route('admin.harga-sampah.index')
            ->with('success', 'Harga sampah berhasil diperbarui.');
    }

    public function destroy(WastePrice $harga_sampah)
    {
        $harga_sampah->delete();

        return redirect()->route('admin.harga-sampah.index')
            ->with('success', 'Harga sampah berhasil dihapus.');
    }
}