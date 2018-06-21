<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\SocialAccount;
use Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * 
     * 
     * Get redirect for incoming social log
     * @return Response
     */

    protected function redirect()
    {
        return Socialite::driver('facebook')->fields([
            'first_name', 'last_name', 'email', 'gender', 'birthday', 'hometown', 'location'
        ])->scopes([
            'email', 'user_birthday','user_hometown','user_location'
        ])->redirect();
    }  

    /**
     * 
     * Create a new user after social log
     * @return Response
     * 
     */

    protected function callback()
    {
        $user = Socialite::driver('facebook')->fields([
            'first_name', 'last_name', 'email', 'gender', 'birthday', 'hometown', 'location'
        ])->user();
        
        $authUser = $this->findOrCreateUser($user);
        Auth::login($authUser, true);
        
        $path = public_path('images/profile_pics')."/".Auth::user()->id."-cropped.jpg";
        if(file_exists($path) === false){
            \Image::make($user->getAvatar())->save($path);
        }
        
        return redirect()->to('/home');
    } 

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @return  \App\User
     */
    protected function findOrCreateUser($user)
    {
        /**
         * 
         * Try found User in SocialAccount table
         * @return \App\User
         * 
         */
        $authUser = SocialAccount::where('provider', 'facebook')
            ->where('provider_user_id',$user->getId())        
            ->first();

        if ($authUser) {
            return User::where('id',$authUser->user_id)->first();
        }

        /**
         * 
         * Create new Account and insert also into SocialAccount
         * @return App\User
         * 
         */
        $createUser = User::create([
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'birthday' => \Carbon\Carbon::createFromFormat('m/d/Y', $user['birthday'])->format('Y-m-d'),
            'email' => $user['email'],
            'password' => "RandomOrNull",
        ]);
          
        SocialAccount::create([
            'user_id'=> $createUser->id,
            'provider'=>'facebook',
            'provider_user_id'=>$user->getId(),
        ]);

        return $createUser;
    }
}
