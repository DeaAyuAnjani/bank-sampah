<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\SelfDeliveryRequest;
use App\Models\WasteCategory;
use Illuminate\Http\Request;

class SelfDeliveryController extends Controller
{
    public function index()
    {
        $deliveries = SelfDeliveryRequest::with('wasteCategory')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('nasabah.antar-sendiri.index', compact('deliveries'));
    }

    public function create()
    {
        $categories = WasteCategory::orderBy('name')->get();

        return view('nasabah.antar-sendiri.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'waste_category_id' => 'required|exists:waste_categories,id',
            'weight' => 'required|numeric|min:0.1',
            'scale_photo' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'delivery_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['scale_photo'] = $request->file('scale_photo')->store('scale-photos', 'public');
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'menunggu_verifikasi';

        SelfDeliveryRequest::create($validated);

        return redirect()->route('nasabah.antar-sendiri.index')
            ->with('success', 'Pengajuan antar sendiri berhasil dikirim. Menunggu verifikasi admin.');
    }

    public function show(SelfDeliveryRequest $antar_sendiri)
    {
        return view('nasabah.antar-sendiri.show', ['delivery' => $antar_sendiri]);
    }

    public function edit(SelfDeliveryRequest $antar_sendiri)
    {
        //
    }

    public function update(Request $request, SelfDeliveryRequest $antar_sendiri)
    {
        //
    }

    public function destroy(SelfDeliveryRequest $antar_sendiri)
    {
        if ($antar_sendiri->status !== 'menunggu_verifikasi') {
            return back()->with('error', 'Tidak bisa menghapus pengajuan yang sudah diproses.');
        }

        \Storage::disk('public')->delete($antar_sendiri->scale_photo);
        $antar_sendiri->delete();

        return redirect()->route('nasabah.antar-sendiri.index')
            ->with('success', 'Pengajuan berhasil dihapus.');
    }
}