<?php

namespace App\Http\Controllers;

use App\Models\PickupLocation;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class AdminPickupLocationController extends Controller
{
    public function index(Request $request)
    {
        $settings = SiteSetting::getSettings();
        $query = PickupLocation::query()->orderBy('sort_order', 'asc')->orderBy('id', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('detail', 'like', "%{$search}%");
            });
        }

        $locations = $query->paginate(15)->withQueryString();

        return view('admin.pickup-locations.index', compact('locations', 'settings'));
    }

    public function create()
    {
        $settings = SiteSetting::getSettings();
        $nextSortOrder = (PickupLocation::max('sort_order') ?? 0) + 1;

        return view('admin.pickup-locations.create', compact('settings', 'nextSortOrder'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'nullable|string|max:500',
            'surcharge' => 'required|integer|min:0',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        PickupLocation::create($validated);

        return redirect()->route('admin.pickup-locations.index')
            ->with('success', 'Titik penjemputan berhasil ditambahkan.');
    }

    public function edit(PickupLocation $pickupLocation)
    {
        $settings = SiteSetting::getSettings();

        return view('admin.pickup-locations.edit', compact('pickupLocation', 'settings'));
    }

    public function update(Request $request, PickupLocation $pickupLocation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'nullable|string|max:500',
            'surcharge' => 'required|integer|min:0',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $pickupLocation->update($validated);

        return redirect()->route('admin.pickup-locations.index')
            ->with('success', 'Titik penjemputan berhasil diperbarui.');
    }

    public function destroy(PickupLocation $pickupLocation)
    {
        $name = $pickupLocation->name;
        $pickupLocation->delete();

        return redirect()->route('admin.pickup-locations.index')
            ->with('success', "Titik penjemputan '{$name}' berhasil dihapus.");
    }

    public function toggleStatus(PickupLocation $pickupLocation)
    {
        $pickupLocation->is_active = !$pickupLocation->is_active;
        $pickupLocation->save();

        return back()->with('success', 'Status titik penjemputan berhasil diubah.');
    }
}
