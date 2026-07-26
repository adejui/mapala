<?php

namespace App\Http\Controllers;

use App\Models\Opa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $opa = Opa::where('email', $googleUser->email)->first();

        if (!$opa) {
            $opa = Opa::updateOrCreate(
                ['email' => $googleUser->getEmail()], // kunci unik
                [
                    'name' => $googleUser->getName(),
                    'organization_name' => $request->organization_name ?? null,
                    'campus_name' => $request->campus_name ?? null,
                    'phone_number' => $request->phone_number ?? null,
                ]
            );
        }

        Auth::guard('opa')->login($opa);

        return redirect()->route('frontend.home');
    }

    public function logout(Request $request)
    {
        Auth::guard('opa')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('frontend.home');
    }
}
