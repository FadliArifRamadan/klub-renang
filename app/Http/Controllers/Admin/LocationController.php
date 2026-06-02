<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LocationController extends Controller
{
    // 1. Menampilkan Semua Data & Form (Bisa Form Tambah atau Form Edit)
    public function index(Request $request)
    {
        $locations = Location::oldest()->paginate(5);

        return view('admin.locations.index', compact('locations'));
    }

    // 2. Menyimpan Data Tempat Latihan Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'address' => $request->address,
        ];

        // Simpan gambar jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('locations', 'public');
        }

        Location::create($data);

        return redirect()->route('admin.locations.index')->with('success', 'Tempat latihan berhasil ditambahkan!');
    }

    // 3. Menyimpan Perubahan Data (Update)
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'address' => $request->address,
        ];

        // Update gambar jika ada file baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($location->image) {
                Storage::disk('public')->delete($location->image);
            }
            $data['image'] = $request->file('image')->store('locations', 'public');
        }

        $location->update($data);

        return redirect()->route('admin.locations.index')->with('success', 'Tempat latihan berhasil diperbarui!');
    }

    // 4. Menghapus Data
    public function destroy(Location $location)
    {
        // Hapus gambar dari storage jika ada
        if ($location->image) {
            Storage::disk('public')->delete($location->image);
        }

        $location->delete();
        return redirect()->back()->with('success', 'Tempat latihan berhasil dihapus!');
    }
}
