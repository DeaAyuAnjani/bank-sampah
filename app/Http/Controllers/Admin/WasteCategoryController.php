<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WasteCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WasteCategoryController extends Controller
{
    public function index()
    {
        $categories = WasteCategory::latest()->paginate(10);
        return view('admin.jenis-sampah.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.jenis-sampah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('waste-categories', 'public');
        }

        WasteCategory::create($validated);

        return redirect()->route('admin.jenis-sampah.index')
            ->with('success', 'Jenis sampah berhasil ditambahkan.');
    }

    public function edit(WasteCategory $jenis_sampah)
    {
        return view('admin.jenis-sampah.edit', ['category' => $jenis_sampah]);
    }

    public function update(Request $request, WasteCategory $jenis_sampah)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($jenis_sampah->image) {
                Storage::disk('public')->delete($jenis_sampah->image);
            }
            $validated['image'] = $request->file('image')->store('waste-categories', 'public');
        }

        $jenis_sampah->update($validated);

        return redirect()->route('admin.jenis-sampah.index')
            ->with('success', 'Jenis sampah berhasil diperbarui.');
    }

    public function destroy(WasteCategory $jenis_sampah)
    {
        if ($jenis_sampah->image) {
            Storage::disk('public')->delete($jenis_sampah->image);
        }

        $jenis_sampah->delete();

        return redirect()->route('admin.jenis-sampah.index')
            ->with('success', 'Jenis sampah berhasil dihapus.');
    }
}