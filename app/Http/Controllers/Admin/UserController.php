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
            'name'           => 'required|string|max:255|unique:users,name',
            'username'       => 'required|string|max:255|unique:users,username',
            'phone'          => 'required|string|max:15',
            'gender'         => 'nullable|in:L,P',
            'role'           => 'required|string|in:admin_finance,admin_operasional,coach,parent,general',
            'password'       => 'required|string|min:8',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'license_files.*'       => 'nullable|file|mimes:pdf,jpeg,png,jpg,webp|max:5120',
            'certification_files.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg,webp|max:5120',
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

            // Proses lisensi: nama + file scan
            $licenseNames = $request->licenses ? json_decode($request->licenses, true) : [];
            $licenseFiles = $request->file('license_files', []);
            $licenses = [];
            foreach ($licenseNames as $i => $name) {
                if (empty($name)) continue;
                $license = ['name' => $name, 'file' => null];
                if (isset($licenseFiles[$i]) && $licenseFiles[$i]->isValid()) {
                    $license['file'] = $licenseFiles[$i]->store('licenses', 'public');
                }
                $licenses[] = $license;
            }
            $data['licenses'] = $licenses;

            // Proses sertifikasi: nama + file scan
            $certNames = $request->certifications ? json_decode($request->certifications, true) : [];
            $certFiles = $request->file('certification_files', []);
            $certifications = [];
            foreach ($certNames as $i => $name) {
                if (empty($name)) continue;
                $cert = ['name' => $name, 'file' => null];
                if (isset($certFiles[$i]) && $certFiles[$i]->isValid()) {
                    $cert['file'] = $certFiles[$i]->store('certifications', 'public');
                }
                $certifications[] = $cert;
            }
            $data['certifications'] = $certifications;
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
            'name'           => 'required|string|max:255|unique:users,name,' . $user->id,
            'username'       => 'required|string|max:255|unique:users,username,' . $user->id,
            'phone'          => 'required|string|max:15',
            'gender'         => 'nullable|in:L,P',
            'role'           => 'required|string|in:admin_finance,admin_operasional,coach,parent,general',
            'password'       => 'nullable|string|min:8',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'license_files.*'       => 'nullable|file|mimes:pdf,jpeg,png,jpg,webp|max:5120',
            'certification_files.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg,webp|max:5120',
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

            // Proses lisensi: nama + file scan
            $licenseNames = $request->licenses ? json_decode($request->licenses, true) : [];
            $licenseFiles = $request->file('license_files', []);
            $existingFiles = $request->existing_license_files ? json_decode($request->existing_license_files, true) : [];
            $licenses = [];

            // Kumpulkan file lama yang masih dipakai untuk menentukan mana yang harus dihapus
            $keepFiles = [];

            foreach ($licenseNames as $i => $name) {
                if (empty($name)) continue;
                $license = ['name' => $name, 'file' => null];

                // Cek apakah ada file baru di-upload untuk index ini
                if (isset($licenseFiles[$i]) && $licenseFiles[$i]->isValid()) {
                    // Hapus file lama jika ada dan diganti dengan file baru
                    if (isset($existingFiles[$i]) && $existingFiles[$i]) {
                        Storage::disk('public')->delete($existingFiles[$i]);
                    }
                    $license['file'] = $licenseFiles[$i]->store('licenses', 'public');
                } elseif (isset($existingFiles[$i]) && $existingFiles[$i]) {
                    // Pertahankan file lama
                    $license['file'] = $existingFiles[$i];
                    $keepFiles[] = $existingFiles[$i];
                }

                $licenses[] = $license;
            }

            // Hapus file lama yang sudah tidak terpakai (item lisensi dihapus)
            $oldLicenses = $user->licenses ?? [];
            foreach ($oldLicenses as $oldLicense) {
                $oldFile = is_array($oldLicense) ? ($oldLicense['file'] ?? null) : null;
                if ($oldFile && !in_array($oldFile, $keepFiles)) {
                    // Cek apakah file ini bukan file yang baru disimpan
                    $newFiles = array_column($licenses, 'file');
                    if (!in_array($oldFile, $newFiles)) {
                        Storage::disk('public')->delete($oldFile);
                    }
                }
            }

            $data['licenses'] = $licenses;

            // Proses sertifikasi: nama + file scan
            $certNames = $request->certifications ? json_decode($request->certifications, true) : [];
            $certFiles = $request->file('certification_files', []);
            $existingCertFiles = $request->existing_certification_files ? json_decode($request->existing_certification_files, true) : [];
            $certifications = [];

            $keepCertFiles = [];

            foreach ($certNames as $i => $name) {
                if (empty($name)) continue;
                $cert = ['name' => $name, 'file' => null];

                if (isset($certFiles[$i]) && $certFiles[$i]->isValid()) {
                    if (isset($existingCertFiles[$i]) && $existingCertFiles[$i]) {
                        Storage::disk('public')->delete($existingCertFiles[$i]);
                    }
                    $cert['file'] = $certFiles[$i]->store('certifications', 'public');
                } elseif (isset($existingCertFiles[$i]) && $existingCertFiles[$i]) {
                    $cert['file'] = $existingCertFiles[$i];
                    $keepCertFiles[] = $existingCertFiles[$i];
                }

                $certifications[] = $cert;
            }

            // Hapus file sertifikasi lama yang sudah tidak terpakai
            $oldCerts = $user->certifications ?? [];
            foreach ($oldCerts as $oldCert) {
                $oldFile = is_array($oldCert) ? ($oldCert['file'] ?? null) : null;
                if ($oldFile && !in_array($oldFile, $keepCertFiles)) {
                    $newCertFiles = array_column($certifications, 'file');
                    if (!in_array($oldFile, $newCertFiles)) {
                        Storage::disk('public')->delete($oldFile);
                    }
                }
            }

            $data['certifications'] = $certifications;
            $data['experience'] = $request->experience;
        } else {
            // Jika role diubah dari Coach ke non-Coach, hapus data coach
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
                $data['image'] = null;
            }
            // Hapus semua file lisensi dan sertifikasi
            $this->deleteCoachFiles($user);
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

        // Hapus semua file lisensi dan sertifikasi dari storage
        $this->deleteCoachFiles($user);

        $user->delete();

        return redirect()->back()->with('success', 'Akun pengguna berhasil dihapus!');
    }

    /**
     * Hapus semua file lisensi dan sertifikasi coach dari storage
     */
    private function deleteCoachFiles(User $user): void
    {
        foreach (['licenses', 'certifications'] as $field) {
            $items = $user->$field ?? [];
            foreach ($items as $item) {
                $file = is_array($item) ? ($item['file'] ?? null) : null;
                if ($file) {
                    Storage::disk('public')->delete($file);
                }
            }
        }
    }
}
