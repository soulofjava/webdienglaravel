<?php

namespace App\Http\Controllers;

use App\Models\Comcode;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class AdminComcodeController extends Controller
{
    /**
     * Tampilkan daftar seluruh comcodes yang dikelompokkan berdasarkan grup
     */
    public function index(Request $request)
    {
        $settings = SiteSetting::getSettings();

        $query = Comcode::query()->orderBy('code_group')->orderBy('sort_order')->orderBy('code_name');

        if ($request->filled('group')) {
            $query->where('code_group', $request->group);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code_name', 'like', "%{$search}%")
                  ->orWhere('code_value', 'like', "%{$search}%")
                  ->orWhere('code_group', 'like', "%{$search}%");
            });
        }

        $comcodes = $query->get()->groupBy('code_group');

        $groups = [
            'package_category' => 'Kategori Paket Tour',
            'package_badge' => 'Label Badge Penjualan',
            'package_duration' => 'Durasi Program Standar',
            'pickup_area' => 'Titik Penjemputan Standar',
        ];

        return view('admin.comcodes.index', compact('settings', 'comcodes', 'groups'));
    }

    /**
     * Simpan kode baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code_group' => 'required|string|max:50',
            'code_value' => 'required|string|max:100',
            'code_name' => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        Comcode::create([
            'code_group' => trim($validated['code_group']),
            'code_value' => trim($validated['code_value']),
            'code_name' => trim($validated['code_name']),
            'description' => $validated['description'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
        ]);

        return redirect()->route('admin.comcodes.index')
            ->with('success', "Master kode '{$validated['code_name']}' berhasil ditambahkan!");
    }

    /**
     * Perbarui kode yang ada
     */
    public function update(Request $request, Comcode $comcode)
    {
        $validated = $request->validate([
            'code_group' => 'required|string|max:50',
            'code_value' => 'required|string|max:100',
            'code_name' => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $comcode->update([
            'code_group' => trim($validated['code_group']),
            'code_value' => trim($validated['code_value']),
            'code_name' => trim($validated['code_name']),
            'description' => $validated['description'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : false,
        ]);

        return redirect()->route('admin.comcodes.index')
            ->with('success', "Master kode '{$comcode->code_name}' berhasil diperbarui!");
    }

    /**
     * Hapus kode
     */
    public function destroy(Comcode $comcode)
    {
        $name = $comcode->code_name;
        $comcode->delete();

        return redirect()->route('admin.comcodes.index')
            ->with('success', "Master kode '{$name}' berhasil dihapus!");
    }
}
