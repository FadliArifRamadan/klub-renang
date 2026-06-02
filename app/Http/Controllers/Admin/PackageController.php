<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    // 1. Menampilkan Semua Data & Form (Tambah/Edit)
    public function index(Request $request)
    {
        $packages = Package::oldest()->get();

        $packageToEdit = null;
        if ($request->has('edit')) {
            $packageToEdit = Package::find($request->edit);
        }

        return view('admin.packages.index', compact('packages', 'packageToEdit'));
    }

    // 2. Menyimpan Paket Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'sessions' => 'required|integer|min:1',
            'active_period_months' => 'required|integer|min:1',
        ]);

        Package::create([
            'name' => $request->name,
            'price' => $request->price,
            'sessions' => $request->sessions,
            'active_period_months' => $request->active_period_months,
        ]);

        return redirect()->route('admin.packages.index')->with('success', 'Paket latihan berhasil ditambahkan!');
    }

    // 3. Menyimpan Perubahan Paket (Update)
    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'sessions' => 'required|integer|min:1',
            'active_period_months' => 'required|integer|min:1',
        ]);

        $package->update([
            'name' => $request->name,
            'price' => $request->price,
            'sessions' => $request->sessions,
            'active_period_months' => $request->active_period_months,
        ]);

        return redirect()->route('admin.packages.index')->with('success', 'Paket latihan berhasil diperbarui!');
    }

    // 4. Menghapus Paket
    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->back()->with('success', 'Paket latihan berhasil dihapus!');
    }
}
