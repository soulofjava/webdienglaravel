<?php

namespace App\Http\Controllers;

use App\Models\Comcode;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminComcodeController extends Controller
{
    /**
     * Tampilkan daftar seluruh comcodes yang dikelompokkan berdasarkan grup
     */
    public function index(Request $request)
    {
        $settings = SiteSetting::getSettings();
        $user = Auth::user();

        $query = Comcode::query()->orderBy('code_group')->orderBy('sort_order')->orderBy('code_name');

        // Scoping data berdasarkan hak akses pengguna
        if ($user && !$user->isSuperAdmin()) {
            $userScope = $user->getSiteScope();
            if ($userScope === 'lotus') {
                // Lotus dapat melihat master kode miliknya ('lotus') dan master kode umum ('global')
                $query->whereIn('site_scope', ['lotus', 'global']);
            } elseif ($userScope === 'tiketdieng') {
                // TiketDieng dapat melihat master kode miliknya ('tiketdieng') dan umum ('global')
                $query->whereIn('site_scope', ['tiketdieng', 'global']);
            } else {
                $query->whereIn('site_scope', [$userScope, 'global']);
            }
        } elseif ($request->filled('scope')) {
            // Superadmin dapat memfilter berdasarkan unit/scope jika diinginkan
            $query->where('site_scope', $request->scope);
        }

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

        return view('admin.comcodes.index', compact('settings', 'comcodes', 'groups', 'user'));
    }

    /**
     * Simpan kode baru
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'code_group' => 'required|string|max:50',
            'code_value' => 'required|string|max:100',
            'code_name' => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'site_scope' => 'nullable|string|in:global,tiketdieng,lotus,jeep,shuttle',
        ]);

        // Tetapkan site_scope:
        // Jika SuperAdmin: gunakan input dari form (default 'global')
        // Jika Sub-Web Admin: paksa otomatis sesuai scope unitnya (misal: 'lotus' atau 'tiketdieng')
        if ($user && $user->isSuperAdmin()) {
            $siteScope = $validated['site_scope'] ?? 'global';
        } else {
            $siteScope = $user ? $user->getSiteScope() : 'global';
        }

        Comcode::create([
            'code_group' => trim($validated['code_group']),
            'site_scope' => $siteScope,
            'code_value' => trim($validated['code_value']),
            'code_name' => trim($validated['code_name']),
            'description' => $validated['description'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
        ]);

        return redirect()->route('admin.comcodes.index')
            ->with('success', "Master kode '{$validated['code_name']}' untuk unit [" . strtoupper($siteScope) . "] berhasil ditambahkan!");
    }

    /**
     * Perbarui kode yang ada
     */
    public function update(Request $request, Comcode $comcode)
    {
        $user = Auth::user();

        if ($user && !$comcode->canManage($user)) {
            abort(403, 'Akses ditolak: Anda tidak memiliki wewenang untuk memodifikasi master kode unit bisnis lain.');
        }

        $validated = $request->validate([
            'code_group' => 'required|string|max:50',
            'code_value' => 'required|string|max:100',
            'code_name' => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'site_scope' => 'nullable|string|in:global,tiketdieng,lotus,jeep,shuttle',
        ]);

        $updateData = [
            'code_group' => trim($validated['code_group']),
            'code_value' => trim($validated['code_value']),
            'code_name' => trim($validated['code_name']),
            'description' => $validated['description'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : false,
        ];

        // Hanya SuperAdmin yang boleh mengubah hak unit (site_scope)
        if ($user && $user->isSuperAdmin() && isset($validated['site_scope'])) {
            $updateData['site_scope'] = $validated['site_scope'];
        }

        $comcode->update($updateData);

        return redirect()->route('admin.comcodes.index')
            ->with('success', "Master kode '{$comcode->code_name}' berhasil diperbarui!");
    }

    /**
     * Hapus kode
     */
    public function destroy(Comcode $comcode)
    {
        $user = Auth::user();

        if ($user && !$comcode->canManage($user)) {
            abort(403, 'Akses ditolak: Anda tidak memiliki wewenang untuk menghapus master kode ini.');
        }

        // Usage Guard: Proteksi integritas database
        $usedCount = $comcode->countUsedPackages();
        if ($usedCount > 0) {
            return redirect()->route('admin.comcodes.index')
                ->with('error', "Gagal menghapus! Master kode '{$comcode->code_name}' sedang digunakan oleh {$usedCount} paket wisata aktif. Hapus atau pindahkan kategori paket terkait terlebih dahulu.");
        }

        $name = $comcode->code_name;
        $comcode->delete();

        return redirect()->route('admin.comcodes.index')
            ->with('success', "Master kode '{$name}' berhasil dihapus!");
    }
}
