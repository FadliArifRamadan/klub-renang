<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SwimmingClass;
use App\Models\ClassCategory;
use Illuminate\Http\Request;

class SwimmingClassController extends Controller
{
    // 1. Tampilkan Semua Kelas & Form Tambah/Edit
    public function index()
    {
        $swimmingClasses = SwimmingClass::with('category')->oldest()->paginate(10);
        $categories = ClassCategory::all();

        return view('admin.swimming_classes.index', compact('swimmingClasses', 'categories'));
    }

    // 2. Simpan Kelas Baru
    public function store(Request $request)
    {
        $request->validate([
            'class_category_id' => 'required|exists:class_categories,id',
            'name' => 'required|string|max:255',
            'age_min' => 'required|integer|min:0',
            'age_max' => 'nullable|integer|gte:age_min',
            'max_quota' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        SwimmingClass::create([
            'class_category_id' => $request->class_category_id,
            'name' => $request->name,
            'age_min' => $request->age_min,
            'age_max' => $request->age_max,
            'max_quota' => $request->max_quota,
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('admin.swimming-classes.index')->with('success', 'Kelas renang berhasil ditambahkan!');
    }

    // 3. Simpan Perubahan Kelas (Update)
    public function update(Request $request, SwimmingClass $swimmingClass)
    {
        $request->validate([
            'class_category_id' => 'required|exists:class_categories,id',
            'name' => 'required|string|max:255',
            'age_min' => 'required|integer|min:0',
            'age_max' => 'nullable|integer|gte:age_min',
            'max_quota' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $swimmingClass->update([
            'class_category_id' => $request->class_category_id,
            'name' => $request->name,
            'age_min' => $request->age_min,
            'age_max' => $request->age_max,
            'max_quota' => $request->max_quota,
            'description' => $request->description,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.swimming-classes.index')->with('success', 'Kelas renang berhasil diperbarui!');
    }

    // 4. Hapus Kelas
    public function destroy(SwimmingClass $swimmingClass)
    {
        // Cek apakah ada murid atau paket aktif yang terikat ke kelas ini
        if ($swimmingClass->students()->count() > 0 || $swimmingClass->packages()->count() > 0) {
            return redirect()->back()->with('error', 'Gagal menghapus! Kelas ini masih digunakan oleh data murid atau paket latihan.');
        }

        $swimmingClass->delete();
        return redirect()->back()->with('success', 'Kelas renang berhasil dihapus!');
    }
}
