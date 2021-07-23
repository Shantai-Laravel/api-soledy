<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\AuthUser;


class SocialLoginController extends Controller
{
    public function redirect($service)
    {
        return Socialite::driver($service)->stateless()->redirect();
    }

    public function callback(Request $request, $service)
    {
        if ($request->input('error') === 'access_denied') {
            return redirect('https://terradigital.ro');
        }

        if ($request->input('error_code') === 200) {
            return redirect('https://terradigital.ro');
        }

        $serviceUser = Socialite::driver($service)->stateless()->user();

        $email = $serviceUser->getEmail();
        $name = $serviceUser->getName();
        $id = $serviceUser->getId();

        $user = AuthUser::where('email', $email)->first();

        if (!$user) {
            $hash = Hash::make($email.$name.$id);
            $user = AuthUser::create([
                'email' => $email,
                'name' => $name,
                'driver' => $service,
                'driver_id' => $id,
                'hash' => $hash
            ]);
        }

        return redirect('https://terradigital.ro/social/login?user='.$user->hash);
    }

    public function getAuthUser(Request $request)
    {
        $user = AuthUser::where('hash', $request->input('hash'))->first();

        return $user;
    }

    public function cancel()
    {
        return redirect('https://terradigital.ro');
    }
}
