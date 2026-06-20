<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Tampilkan Semua Pengguna & Form Dinamis
     */
    public function index(Request $request)
    {
        $role = $request->input('role');
        $search = $request->input('search');

        $query = User::query();

        // Filter role
        if ($role && in_array($role, ['admin', 'coach', 'parent', 'general'])) {
            $query->where('role', $role);
        }

        // Pencarian teks
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->oldest('name')->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users', 'role', 'search'));
    }

    /**
     * Simpan Pengguna Baru ke Database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255|unique:users,name',
            'username' => 'required|string|max:255|unique:users,username',
            'phone'    => 'required|string|max:15',
            'role'     => 'required|string|in:admin,coach,parent,general',
            'password' => 'required|string|min:8',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name'     => $request->name,
            'username' => $request->username,
            'phone'    => $request->phone,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ];

        // Upload foto khusus Coach
        if ($request->role === 'coach' && $request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('coaches', 'public');
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna baru berhasil didaftarkan!');
    }

    /**
     * Simpan Perubahan Data Pengguna (Update)
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255|unique:users,name,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'phone'    => 'required|string|max:15',
            'role'     => 'required|string|in:admin,coach,parent,general',
            'password' => 'nullable|string|min:8',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name'     => $request->name,
            'username' => $request->username,
            'phone'    => $request->phone,
            'role'     => $request->role,
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Penanganan foto khusus Coach
        if ($request->role === 'coach') {
            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($user->image) {
                    Storage::disk('public')->delete($user->image);
                }
                $data['image'] = $request->file('image')->store('coaches', 'public');
            }
        } else {
            // Jika role diubah dari Coach ke non-Coach, hapus gambar lamanya
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
                $data['image'] = null;
            }
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * Hapus Akun Pengguna
     */
    public function destroy(User $user)
    {
        // Cegah Admin menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri demi alasan keamanan.');
        }

        // Hapus gambar dari storage jika ada
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()->back()->with('success', 'Akun pengguna berhasil dihapus!');
    }
}
