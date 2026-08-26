<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Founder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FounderController extends Controller
{
    /**
     * Display listing of founders (with modals for create/edit/delete).
     */
    public function index()
    {
        $founders = Founder::orderBy('order')->paginate(10);
        return view('admin.founders.index', compact('founders'));
    }

    /**
     * Store a new founder.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'position'  => 'required|string|max:255',
            'bio'       => 'nullable|string',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'instagram' => 'nullable|string|max:255',
            'linkedin'  => 'nullable|string|max:255',
            'tiktok'    => 'nullable|string|max:255',
            'order'     => 'nullable|integer|min:0',
            'is_active' => 'nullable',
        ]);

        $data = [
            'name'     => $request->name,
            'position' => $request->position,
            'bio'      => $request->bio,
            'order'    => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
            'social_media' => array_filter([
                'instagram' => $request->instagram,
                'linkedin'  => $request->linkedin,
                'tiktok'    => $request->tiktok,
            ]),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('founders', 'public');
        }

        Founder::create($data);

        return redirect()->route('admin.founders.index')->with('success', 'Data founder berhasil ditambahkan!');
    }

    /**
     * Update an existing founder.
     */
    public function update(Request $request, Founder $founder)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'position'  => 'required|string|max:255',
            'bio'       => 'nullable|string',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'instagram' => 'nullable|string|max:255',
            'linkedin'  => 'nullable|string|max:255',
            'tiktok'    => 'nullable|string|max:255',
            'order'     => 'nullable|integer|min:0',
            'is_active' => 'nullable',
        ]);

        $data = [
            'name'     => $request->name,
            'position' => $request->position,
            'bio'      => $request->bio,
            'order'    => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
            'social_media' => array_filter([
                'instagram' => $request->instagram,
                'linkedin'  => $request->linkedin,
                'tiktok'    => $request->tiktok,
            ]),
        ];

        if ($request->hasFile('image')) {
            if ($founder->image) {
                Storage::disk('public')->delete($founder->image);
            }
            $data['image'] = $request->file('image')->store('founders', 'public');
        }

        $founder->update($data);

        return redirect()->route('admin.founders.index')->with('success', 'Data founder berhasil diperbarui!');
    }

    /**
     * Delete a founder.
     */
    public function destroy(Founder $founder)
    {
        if ($founder->image) {
            Storage::disk('public')->delete($founder->image);
        }

        $founder->delete();

        return redirect()->back()->with('success', 'Data founder berhasil dihapus!');
    }
}
