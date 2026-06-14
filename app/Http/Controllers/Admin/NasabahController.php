<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NasabahController extends Controller
{
    public function index()
    {
        $nasabahs = User::where('role', 'nasabah')
            ->withCount('transactions')
            ->latest()
            ->paginate(10);

        return view('admin.nasabah.index', compact('nasabahs'));
    }

    public function create()
    {
        return view('admin.nasabah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'required|string|min:8',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'nasabah';

        User::create($validated);

        return redirect()->route('admin.nasabah.index')
            ->with('success', 'Nasabah berhasil ditambahkan.');
    }

    public function show(User $nasabah)
    {
        $nasabah->load(['transactions.wasteCategory', 'pickupRequests', 'wallet']);

        return view('admin.nasabah.show', ['nasabah' => $nasabah]);
    }

    public function edit(User $nasabah)
    {
        return view('admin.nasabah.edit', ['nasabah' => $nasabah]);
    }

    public function update(Request $request, User $nasabah)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $nasabah->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $nasabah->update($validated);

        return redirect()->route('admin.nasabah.index')
            ->with('success', 'Data nasabah berhasil diperbarui.');
    }

    public function destroy(User $nasabah)
    {
        $nasabah->delete();

        return redirect()->route('admin.nasabah.index')
            ->with('success', 'Nasabah berhasil dihapus.');
    }
}