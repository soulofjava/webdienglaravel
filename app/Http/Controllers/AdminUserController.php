<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    /**
     * Tampilkan daftar seluruh pengguna pengelola sistem.
     */
    public function index(Request $request)
    {
        $settings = SiteSetting::getSettings();

        $query = User::with('roles')->orderBy('id', 'asc');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $roleFilter = $request->role;
            $query->whereHas('roles', function ($q) use ($roleFilter) {
                $q->where('name', $roleFilter);
            });
        }

        $users = $query->paginate(15)->withQueryString();
        $roles = Role::all();
        $totalSuperadmins = User::role('superadmin')->count();

        return view('admin.users.index', compact('settings', 'users', 'roles', 'totalSuperadmins'));
    }

    /**
     * Simpan pengguna pengelola baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:superadmin,admin'],
        ], [
            'name.required' => 'Nama lengkap pengelola wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini sudah terdaftar di sistem.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal berjumlah 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'role.required' => 'Role pengelola wajib dipilih.',
            'role.in' => 'Pilihan role tidak valid.',
        ]);

        $user = User::create([
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('admin.users.index')->with('success', "Akun pengelola '{$user->name}' ({$validated['role']}) berhasil ditambahkan!");
    }

    /**
     * Perbarui data pengguna pengelola.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:superadmin,admin'],
        ], [
            'name.required' => 'Nama lengkap pengelola wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini sudah dipakai oleh akun lain.',
            'password.min' => 'Kata sandi baru minimal berjumlah 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'role.required' => 'Role pengelola wajib dipilih.',
            'role.in' => 'Pilihan role tidak valid.',
        ]);

        // Proteksi: Tidak boleh mencopot role superadmin miliknya sendiri jika dia adalah superadmin terakhir
        if ($user->id === Auth::id() && $user->hasRole('superadmin') && $validated['role'] !== 'superadmin') {
            $superadminCount = User::role('superadmin')->count();
            if ($superadminCount <= 1) {
                return back()->withErrors(['role' => 'Anda tidak dapat menurunkan role akun Anda sendiri karena Anda adalah satu-satunya Superadmin di sistem.']);
            }
        }

        $user->name = trim($validated['name']);
        $user->email = strtolower(trim($validated['email']));

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();
        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')->with('success', "Data akun pengelola '{$user->name}' berhasil diperbarui!");
    }

    /**
     * Hapus pengguna pengelola dari sistem.
     */
    public function destroy(User $user)
    {
        // Proteksi 1: Tidak boleh menghapus akun sendiri yang sedang aktif digunakan
        if ($user->id === Auth::id()) {
            return back()->withErrors(['delete_error' => 'Keamanan sistem: Anda tidak dapat menghapus akun Anda sendiri saat sedang masuk!']);
        }

        // Proteksi 2: Tidak boleh menghapus superadmin jika tersisa hanya 1
        if ($user->hasRole('superadmin')) {
            $superadminCount = User::role('superadmin')->count();
            if ($superadminCount <= 1) {
                return back()->withErrors(['delete_error' => 'Gagal menghapus: Akun ini adalah Super Administrator terakhir di sistem.']);
            }
        }

        $deletedName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "Akun pengelola '{$deletedName}' berhasil dihapus dari sistem.");
    }
}
