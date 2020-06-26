<?php
namespace App;
use Laravel\Socialite\Contracts\User as ProviderUser;


class SocailAccountService{
    public function findorcreate(ProviderUser $provideruser,$provider){
        $account = SocialAccount::where('provider_id',$provideruser->getId())->where('provider_name',$provider)->first();
        if($account){
            return $account->user;
        }else{
            $user = User::where('email',$provideruser->getEmail())->first();
            if(!$user){
                $user = User::create([
                    'email' => $provideruser->getEmail(),
                    'name' => $provideruser->getName()
                ]);
            }
            $user->accounts()->create([
                'provider_id' => $provideruser->getId(),
                'provider_name' => $provider
            ]);
            return $user;
        }
    }
}
