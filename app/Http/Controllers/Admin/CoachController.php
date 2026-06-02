<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CoachController extends Controller
{
    // 1. Tampilkan Semua Coach & Form Dinamis
    public function index(Request $request)
    {
        // Hanya mengambil user yang rolenya 'coach'
        $coaches = User::where('role', 'coach')->oldest()->get();

        // Cek apakah admin sedang mengklik tombol edit coach tertentu
        $coachToEdit = null;
        if ($request->has('edit')) {
            $coachToEdit = User::where('role', 'coach')->find($request->edit);
        }

        return view('admin.coaches.index', compact('coaches', 'coachToEdit'));
    }

    // 2. Simpan Akun Coach Baru ke Database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'role' => 'coach', // Kunci otomatis sebagai Coach
            'password' => Hash::make($request->password),
        ]);

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

        $coach->update($data);

        return redirect()->route('admin.coaches.index')->with('success', 'Data Coach berhasil diperbarui!');
    }

    // 4. Hapus Akun Coach
    public function destroy(User $coach)
    {
        if ($coach->role !== 'coach') {
            abort(403);
        }

        $coach->delete();
        return redirect()->back()->with('success', 'Akun Coach berhasil dihapus!');
    }
}
