<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\SocialAccount;
use Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Geocoder\GeocoderServiceProvider;

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
            'email', 'user_birthday','user_hometown','user_location','user_gender'
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
            
        return redirect()->to('/home');
        //return $user['location']['name'];
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
            'email' => $user['email']
        ]);
          
        SocialAccount::create([
            'user_id'=> $createUser->id,
            'provider'=>'facebook',
            'provider_user_id'=>$user->getId(),
        ]);

        $path = public_path('images/profile_pics')."/".$createUser->id."-cropped.jpg";
        if(file_exists($path) === false){
            \Image::make($user->getAvatar())->save($path);
        }
        
        \Log::info("gender ".$createUser->gender);

        if($createUser->gender === NULL AND !empty($user['gender'])){
            $createUser->gender = $user['gender'];
        }
        
        if($createUser->born_city_id === NULL AND !empty($user['hometown']['name'])){
            $city = \Geocoder::setLanguage('it')->getCoordinatesForAddress($user['hometown']['name']);
            if(!$bornCity = \App\City::where('text', $city['formatted_address'])->first()) {
                $bornCity = new \App\City;
                $bornCity->text = $city['formatted_address'];
                $bornCity->latitude = $city['lat'];
                $bornCity->longitude = $city['lng'];
                $bornCity->save();
            }
            $createUser->born_city_id = $bornCity->id;
        }

        if($createUser->living_city_id === NULL AND !empty($user['location']['name'])){
            $city = \Geocoder::setLanguage('it')->getCoordinatesForAddress($user['location']['name']);
            if(!$livingCity = \App\City::where('text', $city['formatted_address'])->first()) {
                $livingCity = new \App\City;
                $livingCity->text = $city['formatted_address'];
                $livingCity->latitude = $city['lat'];
                $livingCity->longitude = $city['lng'];
                $livingCity->save();
            }
            $createUser->living_city_id = $livingCity->id;
        }

        $createUser->save();

        return $createUser;
    }

}
