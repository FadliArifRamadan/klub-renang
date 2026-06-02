<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CoachController extends Controller
{
    // 1. Tampilkan Semua Coach & Form Dinamis
    public function index(Request $request)
    {
        // Hanya mengambil user yang rolenya 'coach'
        $coaches = User::where('role', 'coach')->oldest()->paginate(5);

        return view('admin.coaches.index', compact('coaches'));
    }

    // 2. Simpan Akun Coach Baru ke Database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'role' => 'coach', // Kunci otomatis sebagai Coach
            'password' => Hash::make($request->password),
        ];

        // Simpan gambar jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('coaches', 'public');
        }

        User::create($data);

        return redirect()->route('admin.coaches.index')->with('success', 'Akun Coach berhasil didaftarkan!');
    }

    // 3. Simpan Perubahan Data Coach (Update)
    public function update(Request $request, User $coach)
    {
        // Pengaman: Pastikan user yang mau diedit benar-benar ber-role coach
        if ($coach->role !== 'coach') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $coach->id,
            'phone' => 'required|string|max:15',
            'password' => 'nullable|string|min:8', // Password opsional saat edit
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
        ];

        // Jika kolom password diisi admin, baru kita update password barunya
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Update gambar jika ada file baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($coach->image) {
                Storage::disk('public')->delete($coach->image);
            }
            $data['image'] = $request->file('image')->store('coaches', 'public');
        }

        $coach->update($data);

        return redirect()->route('admin.coaches.index')->with('success', 'Data Coach berhasil diperbarui!');
    }

    // 4. Hapus Akun Coach
    public function destroy(User $coach)
    {
        if ($coach->role !== 'coach') {
            abort(403);
        }

        // Hapus gambar dari storage jika ada
        if ($coach->image) {
            Storage::disk('public')->delete($coach->image);
        }

        $coach->delete();
        return redirect()->back()->with('success', 'Akun Coach berhasil dihapus!');
    }
}
