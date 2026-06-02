<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // 1. Menampilkan Semua Data & Form (Bisa Form Tambah atau Form Edit)
    public function index(Request $request)
    {
        $locations = Location::oldest()->get();

        // Cari tahu apakah admin sedang mengklik tombol edit
        $locationToEdit = null;
        if ($request->has('edit')) {
            $locationToEdit = Location::find($request->edit);
        }

        return view('admin.locations.index', compact('locations', 'locationToEdit'));
    }

    // 2. Menyimpan Data Tempat Latihan Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        Location::create([
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.locations.index')->with('success', 'Tempat latihan berhasil ditambahkan!');
    }

    // 3. Menyimpan Perubahan Data (Update)
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $location->update([
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.locations.index')->with('success', 'Tempat latihan berhasil diperbarui!');
    }

    // 4. Menghapus Data
    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->back()->with('success', 'Tempat latihan berhasil dihapus!');
    }
}
