<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilOpaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $previous = url()->previous();

        // Simpan hanya jika bukan halaman profile sendiri
        if (
            !str_contains($previous, '/profile') &&
            !str_contains($previous, '/opas')
        ) {

            session([
                'profile_back_url' => $previous
            ]);
        }

        return view('frontend.opas.index');
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
        $opa = auth('opa')->user();

        // VALIDASI + PESAN CUSTOM
        $request->validate([
            'name' => 'required|string|max:255',
            'campus_name' => 'required|string|max:255',
            'organization_name' => 'required|string|max:255',
            'phone_number' => 'required|digits_between:10,15',
            'email' => 'required|email',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',

            'campus_name.required' => 'Kampus asal wajib diisi.',

            'organization_name.required' => 'Organisasi wajib diisi.',

            'phone_number.required' => 'Nomor WhatsApp wajib diisi.',
            'phone_number.digits_between' => 'Nomor WhatsApp harus 10-15 digit.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        // UPDATE DATA
        $opa->update([
            'name' => $request->name,
            'campus_name' => $request->campus_name,
            'organization_name' => $request->organization_name,
            'phone_number' => $request->phone_number,
            // email tidak diubah karena readonly (opsional)
        ]);

        return redirect()
            ->route('frontend.opa.profile')
            ->with('success', 'Profile berhasil diperbarui');

        // return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePhotoOpa(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $opa = auth('opa')->user();

        if ($request->hasFile('photo')) {

            // Hapus foto lama (kalau bukan default)
            if ($opa->photo && $opa->photo !== 'imgUsers/default-image.png') {
                Storage::disk('public')->delete($opa->photo);
            }

            // Upload foto baru
            $path = $request->file('photo')->store('imgOpas', 'public');

            // Simpan ke DB
            $opa->photo = $path;
            $opa->save();
        }

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function deletePhotoOpa()
    {
        $opa = auth('opa')->user();

        // Cek kalau ada foto & bukan default
        if ($opa->photo && $opa->photo !== 'imgUsers/default-image.png') {

            // Hapus file dari storage
            Storage::disk('public')->delete($opa->photo);
        }

        // Set ke default / null
        $opa->photo = null;
        $opa->save();

        return back()->with('success', 'Foto profil berhasil dihapus.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
