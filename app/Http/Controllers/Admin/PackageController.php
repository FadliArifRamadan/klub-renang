<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\SwimmingClass;
use App\Models\Location;
use App\Models\PackageLocationPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    // 1. Menampilkan Semua Data & Form (Tambah/Edit)
    public function index(Request $request)
    {
        $packages = Package::with(['swimmingClass.category', 'locationPrices.location'])->oldest()->paginate(10);
        $swimmingClasses = SwimmingClass::with('category')->where('is_active', true)->get();
        $locations = Location::oldest()->get();

        return view('admin.packages.index', compact('packages', 'swimmingClasses', 'locations'));
    }

    // 2. Menyimpan Paket Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'swimming_class_id' => 'required|exists:swimming_classes,id',
            'package_type' => 'required|in:regular,private,single_session,monthly_prestasi',
            'is_location_based' => 'nullable|boolean',
            'price' => 'required_without:is_location_based|nullable|numeric|min:0',
            'sessions' => 'required|integer|min:1',
            'swim_sessions' => 'nullable|integer|min:0',
            'dryland_sessions' => 'nullable|integer|min:0',
            'active_period_months' => 'required|integer|min:1',
            'location_prices' => 'required_if:is_location_based,1|array',
            'location_prices.*' => 'nullable|numeric|min:0',
        ]);

        $isLocationBased = $request->has('is_location_based') && $request->is_location_based == 1;

        DB::transaction(function () use ($request, $isLocationBased) {
            $package = Package::create([
                'name' => $request->name,
                'swimming_class_id' => $request->swimming_class_id,
                'package_type' => $request->package_type,
                'sessions' => $request->sessions,
                'swim_sessions' => $request->swim_sessions ?? $request->sessions,
                'dryland_sessions' => $request->dryland_sessions,
                'active_period_months' => $request->active_period_months,
                'is_location_based' => $isLocationBased,
                'price' => $isLocationBased ? null : $request->price,
            ]);

            if ($isLocationBased && $request->has('location_prices')) {
                foreach ($request->location_prices as $locationId => $price) {
                    if ($price !== null && $price !== '') {
                        PackageLocationPrice::create([
                            'package_id' => $package->id,
                            'location_id' => $locationId,
                            'price' => $price,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.packages.index')->with('success', 'Paket latihan berhasil ditambahkan!');
    }

    // 3. Menyimpan Perubahan Paket (Update)
    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'swimming_class_id' => 'required|exists:swimming_classes,id',
            'package_type' => 'required|in:regular,private,single_session,monthly_prestasi',
            'is_location_based' => 'nullable|boolean',
            'price' => 'required_without:is_location_based|nullable|numeric|min:0',
            'sessions' => 'required|integer|min:1',
            'swim_sessions' => 'nullable|integer|min:0',
            'dryland_sessions' => 'nullable|integer|min:0',
            'active_period_months' => 'required|integer|min:1',
            'location_prices' => 'required_if:is_location_based,1|array',
            'location_prices.*' => 'nullable|numeric|min:0',
        ]);

        $isLocationBased = $request->has('is_location_based') && $request->is_location_based == 1;

        DB::transaction(function () use ($request, $package, $isLocationBased) {
            $package->update([
                'name' => $request->name,
                'swimming_class_id' => $request->swimming_class_id,
                'package_type' => $request->package_type,
                'sessions' => $request->sessions,
                'swim_sessions' => $request->swim_sessions ?? $request->sessions,
                'dryland_sessions' => $request->dryland_sessions,
                'active_period_months' => $request->active_period_months,
                'is_location_based' => $isLocationBased,
                'price' => $isLocationBased ? null : $request->price,
            ]);

            // Clear old prices
            PackageLocationPrice::where('package_id', $package->id)->delete();

            if ($isLocationBased && $request->has('location_prices')) {
                foreach ($request->location_prices as $locationId => $price) {
                    if ($price !== null && $price !== '') {
                        PackageLocationPrice::create([
                            'package_id' => $package->id,
                            'location_id' => $locationId,
                            'price' => $price,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.packages.index')->with('success', 'Paket latihan berhasil diperbarui!');
    }

    // 4. Menghapus Paket
    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->back()->with('success', 'Paket latihan berhasil dihapus!');
    }
}
