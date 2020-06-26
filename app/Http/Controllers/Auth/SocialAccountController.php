<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\SocailAccountService;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;


class SocialAccountController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function handleProviderCallback(SocailAccountService $profileService,$provider)
    {

        try {
            //methode user() will get the data form your account
            $user = Socialite::driver($provider)->user();
        }catch (\Exception $e){
            return redirect()->to('login');
        }

        $authuser = $profileService->findorcreate($user,$provider);
        auth()->login($authuser,true);
        return redirect()->to('home');


    }
}
