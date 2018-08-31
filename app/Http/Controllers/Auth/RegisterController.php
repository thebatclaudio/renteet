<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\VerifyUser;
use App\Mail\VerifyMail;
use Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Input;

class RegisterController extends Controller
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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/complete-signup/upload-picture/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'day' => 'required|integer',
            'month' => 'required|integer',
            'year' => 'required|integer',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'condition' => 'accepted',
            'telephone' => 'max:20'
        ], [
            'first_name.required' => 'Il nome è un campo obbligatorio',
            'last_name.required' => 'Il cognome è un campo obbligatorio',
            'day.required' => 'La data di nascita è un campo obbligatorio',
            'month.required' => 'La data di nascita è un campo obbligatorio',
            'year.required' => 'La data di nascita è un campo obbligatorio',
            'email.required' => 'L\'indirizzo E-mail è un campo obbligatorio',
            'email.unique' => 'L\'indirizzo E-mail inserito è già associato ad un altro utente',
            'password.required' => 'La password è un campo obbligatorio',
            'password.min' => 'La password deve contenere almeno 8 caratteri',
            'password.confirmed' => 'Le due password non corrispondono',
            'condition.accepted' => 'Per registrarti devi accettare i termini e le condizioni di utilizzo',
            'telephone.max' => 'Il numero non risulta valido'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $telephone = null;
        if($data['telephone'] != "") $telephone = $data['telephone'];
        
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'birthday' => \Carbon\Carbon::create($data['year'], $data['month'], $data['day'])->format('Y-m-d'),
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'telephone' => $telephone
        ]);

        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => str_random(40)
        ]);

        Mail::to($user->email)->send(new VerifyMail($user));

        return $user;
    }

    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $success = "Il tuo account è stato verificato. Adesso puoi effettuare l'accesso";
            }else{
                $success = "Il tuo account è stato verificato. Adesso puoi effettuare l'accesso";
            }
        }else{
            return redirect('/login')->with('warning', "Si è verificato un errore");
        }
 
        return redirect('/login')->with('success', $success);
    }
}
