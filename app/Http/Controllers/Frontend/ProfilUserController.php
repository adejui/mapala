<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ActivityMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $activity_histories = ActivityMember::where('user_id', auth('web')->user()->id)
            ->latest()
            ->paginate(3);
        return view('frontend.users.index', compact('activity_histories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all);

        $user = auth('web')->user();

        // VALIDASI + PESAN CUSTOM
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|string|max:255',
            'phone_number' => 'nullable|digits_between:10,15',
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'full_name.max' => 'Nama maksimal 255 karakter.',

            'phone_number.digits_between' => 'Nomor WhatsApp harus 10-15 digit.',
        ]);

        // UPDATE DATA
        $user->update([
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function updatePassword(Request $request)
    {
        $user = auth('web')->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|different:current_password',
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password minimal 6 karakter.',
            'new_password.different' => 'Password baru harus berbeda dari password lama.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama tidak sesuai.'
            ])->withInput();
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth('web')->user();

        if ($request->hasFile('photo')) {
            // Hapus foto lama kalau ada dan bukan default
            if ($user->photo && $user->photo !== 'imgUsers/default-image.png') {
                $oldPath = storage_path('app/public/' . $user->photo);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Simpan foto baru ke folder imgUsers di storage
            $path = $request->file('photo')->store('imgUsers', 'public');

            // Simpan path ke database
            $user->photo = $path;
            $user->save();
        }

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function deletePhoto()
    {
        $user = auth('web')->user();

        // pastikan user punya foto & bukan default
        if ($user->photo && $user->photo !== 'imgUsers/default-image.png') {

            $path = storage_path('app/public/' . $user->photo);

            // hapus file jika benar-benar ada
            if (file_exists($path)) {
                unlink($path);
            }

            // kosongkan kolom photo di database
            $user->photo = null;
            $user->save();
        }

        return back()->with('success', 'Foto profil berhasil dihapus.');
    }
    public function destroy(string $id)
    {
        //
    }
}
