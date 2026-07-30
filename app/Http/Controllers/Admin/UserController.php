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
        if ($role) {
            if ($role === 'admin') {
                $query->whereIn('role', ['admin_finance', 'admin_operasional', 'admin']);
            } else {
                $query->where('role', $role);
            }
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
            'gender'   => 'nullable|in:L,P',
            'role'     => 'required|string|in:admin_finance,admin_operasional,coach,parent,general',
            'password' => 'required|string|min:8',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name'     => $request->name,
            'username' => $request->username,
            'phone'    => $request->phone,
            'gender'   => $request->gender,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ];

        // Data khusus Coach
        if ($request->role === 'coach') {
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('coaches', 'public');
            }
            $data['licenses'] = $request->licenses ? json_decode($request->licenses, true) : [];
            $data['certifications'] = $request->certifications ? json_decode($request->certifications, true) : [];
            $data['experience'] = $request->experience;
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
            'gender'   => 'nullable|in:L,P',
            'role'     => 'required|string|in:admin_finance,admin_operasional,coach,parent,general',
            'password' => 'nullable|string|min:8',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name'     => $request->name,
            'username' => $request->username,
            'phone'    => $request->phone,
            'gender'   => $request->gender,
            'role'     => $request->role,
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Penanganan data khusus Coach
        if ($request->role === 'coach') {
            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($user->image) {
                    Storage::disk('public')->delete($user->image);
                }
                $data['image'] = $request->file('image')->store('coaches', 'public');
            }
            $data['licenses'] = $request->licenses ? json_decode($request->licenses, true) : [];
            $data['certifications'] = $request->certifications ? json_decode($request->certifications, true) : [];
            $data['experience'] = $request->experience;
        } else {
            // Jika role diubah dari Coach ke non-Coach, hapus data coach
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
                $data['image'] = null;
            }
            $data['licenses'] = null;
            $data['certifications'] = null;
            $data['experience'] = null;
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
