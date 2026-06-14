<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\PickupRequest;
use App\Models\WasteCategory;
use Illuminate\Http\Request;

class PickupRequestController extends Controller
{
    public function index()
    {
        $pickups = PickupRequest::with('wasteCategory')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('nasabah.pickup.index', compact('pickups'));
    }

    public function create()
    {
        $categories = WasteCategory::orderBy('name')->get();

        return view('nasabah.pickup.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'waste_category_id' => 'required|exists:waste_categories,id',
            'estimated_weight' => 'required|numeric|min:0.1',
            'pickup_date' => 'required|date',
            'address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        PickupRequest::create([
            'user_id' => auth()->id(),
            'waste_category_id' => $validated['waste_category_id'],
            'estimated_weight' => $validated['estimated_weight'],
            'pickup_date' => $validated['pickup_date'],
            'pickup_address' => $validated['address'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'menunggu_konfirmasi',
        ]);

        return redirect()
            ->route('nasabah.pickup.index')
            ->with('success', 'Permintaan pickup berhasil dikirim.');
    }

    public function show(PickupRequest $pickup)
    {
        //
    }

    public function edit(PickupRequest $pickup)
    {
        //
    }

    public function update(Request $request, PickupRequest $pickup)
    {
        //
    }

    public function destroy(PickupRequest $pickup)
    {
        //
    }
}