<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use App\Mail\VerifyMail;
use App\VerifyUser;
use Mail;

class UserController extends Controller
{
    public function sendNewVerifyToken(request $request){
        if($user = \Auth::user()){
            $verifyUser = VerifyUser::where('user_id', $user->id)->first();
            if(isset($verifyUser)){
                $verifyUser->token = str_random(40);
                $verifyUser->updated_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
                $verifyUser->counter = $verifyUser->counter + 1;
                if(!$verifyUser->save()){
                    return response()->json([
                        'status' => 'KO2'
                    ]);
                }
            }else{
                $verifyUser = VerifyUser::create([
                    'user_id' => $user->id,
                    'token' => str_random(40),
                    'counter' => 0
                ]);
            }
            Mail::to($user->email)->send(new VerifyMail($user,$verifyUser->token));
            return response()->json([
                'status' => 'OK',
                'email' => $user->email
            ]);
        }
        return response()->json([
            'status' => 'KO2'
        ]);
    }

    public function editEmail(request $request){   

        if(\Auth::user()->email != $request->email){
            $validatorRules['email'] = 'required|string|email|max:255|unique:users';
            $validatorMessages['email.required'] = 'L\'indirizzo E-mail è un campo obbligatorio';
            $validatorMessages['email.unique'] = 'L\'indirizzo E-mail inserito è già associato ad un altro utente';
        }

        $validatedData = $request->validate($validatorRules, $validatorMessages);
        
        if($request->email != "") \Auth::user()->email = $request->email;
        if(\Auth::user()->save()){
            return response()->json([
                'status' => 'OK'
            ]);
        }
        return response()->json([
            'status' => 'KO'
        ]);
    }

    public function showEditProfileForm() {
        $interests = "";
        $languages = "";

        foreach(\Auth::user()->interests as $interest){
            if($interests == ""){
                $interests=$interest->name;
            }else{
                $interests=$interests.",".$interest->name;
            }
        }

        foreach(\Auth::user()->languages as $language){
            if($languages == ""){
                $languages=$language->name;
            }else{
                $languages=$languages.",".$language->name;
            }
        }

        return view('profile.edit',[
            'user' => \Auth::user(),
            'birth_day' => \Carbon\Carbon::parse(\Auth::user()->birthday)->day,
            'birth_month' => \Carbon\Carbon::parse(\Auth::user()->birthday)->month,
            'birth_year' => \Carbon\Carbon::parse(\Auth::user()->birthday)->year,
            'interests' => $interests,
            'languages' => $languages,
            'months_it' => ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre']
        ]);
    }

    public function editPersonalInfo(Request $request){

        $validatorRules = [
            'gender' => 'required',
            'living_city' => 'required_if:living_city_required,true',
            'born_city' => 'required_if:born_city_required,true',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'telephone' => 'max:20'
        ];

        $validatorMessages = [
            'gender.required' => 'Inserisci il tuo genere',
            'living_city.required_if' => 'Inserisci la tua città di residenza',
            'born_city.required_if' => 'Inserisci la tua città di nascita',
            'first_name.required' => 'Il nome è un campo obbligatorio',
            'last_name.required' => 'Il cognome è un campo obbligatorio',
            'telephone.max' => 'Il numero non risulta valido'
        ];

        if(\Auth::user()->birthday == '0000-01-01') {
            $validatorRules['day'] = 'required|integer';
            $validatorRules['month'] = 'required|integer';
            $validatorRules['year'] = 'required|integer';
            $validatorMessages['day.required'] = 'Inserisci la tua data di nascita';
            $validatorMessages['month.required'] = 'Inserisci la tua data di nascita';
            $validatorMessages['year.required'] = 'Inserisci la tua data di nascita';
            $validatorMessages['day.ineger'] = 'Inserisci la tua data di nascita';
            $validatorMessages['month.ineger'] = 'Inserisci la tua data di nascita';
            $validatorMessages['year.ineger'] = 'Inserisci la tua data di nascita';
        }

        if(\Auth::user()->email != $request->email){
            $validatorRules['email'] = 'required|string|email|max:255|unique:users';
            $validatorMessages['email.required'] = 'L\'indirizzo E-mail è un campo obbligatorio';
            $validatorMessages['email.unique'] = 'L\'indirizzo E-mail inserito è già associato ad un altro utente';
        }

        if($request->degree_course != ""){
            $validatorRules['university'] = 'required';
            $validatorMessages['university.required'] = 'Per poter inserire il corso di studi è necessario definire anche la relativa Università';
        }
        
        $validatedData = $request->validate($validatorRules, $validatorMessages);

        $user = \Auth::user();
        $user->gender = $request->gender;

        if($request->first_name != "") $user->first_name = $request->first_name;
        if($request->last_name != "") $user->last_name = $request->last_name;
        if($request->email != "") $user->email = $request->email;
        if($request->telephone != ""){
            $user->telephone = $request->telephone;
        }else{
            $user->telephone = null;
        }

        if(\Auth::user()->birthday != '0000-01-01') {
            if(\Carbon\Carbon::create($request->year, $request->month, $request->day) > \Carbon\Carbon::now()->subYears(18)) {
                return back()->withErrors(['Inserisci una data di nascita valida']);
            }
            $user->birthday = \Carbon\Carbon::create($request->year, $request->month, $request->day)->format('Y-m-d');
        }
        // controllo se le città esistono già
        if($request->living_city){
            if(!$livingCity = \App\City::where('text', $request->living_city)->first()) {
                $city = \Geocoder::getCoordinatesForAddress($request->living_city);
                $livingCity = new \App\City;
                $livingCity->text = $city['formatted_address'];
                $livingCity->latitude = $city['lat'];
                $livingCity->longitude = $city['lng'];
                $livingCity->save();
            }
            $user->living_city_id = $livingCity->id;
        }

        if($request->born_city){
            if(!$bornCity = \App\City::where('text',$request->born_city)->first()) {
                $city = \Geocoder::getCoordinatesForAddress($request->born_city);
                $bornCity = new \App\City;
                $bornCity->text = $city['formatted_address'];
                $bornCity->latitude = $city['lat'];
                $bornCity->longitude = $city['lng'];
                $bornCity->save();
            }

            $user->born_city_id = $bornCity->id;
        }

        if($request->university !== ""){
            $user->university = $request->university;
        }else{
            $user->university = null;
        }

        if($request->degree_course !== ""){
            $user->degree_course = $request->degree_course;
        }else{
            $user->degree_course = null;
        }
       
        if($request->job !== ""){
            $user->job = $request->job;
        }else{
            $user->job = null;
        }

        if($request->description !== ""){ 
            $user->description = $request->description;
        }else{
            $user->description = null;
        }
        
        $interests = explode(",",$request->interests);
        $interestsToAdd = [];
        foreach($interests as $interest){

            if($checkInterest = \App\Interest::where('name', $interest)->first()) {
                $interestsToAdd[] = $checkInterest->id;
            } else {
                $newInterest = new \App\Interest;
                $newInterest->name = $interest;
                $newInterest->save();
                $interestsToAdd[] = $newInterest->id;
            }

            $user->interests()->syncWithoutDetaching($interestsToAdd);
        }

        $languages = explode(",",$request->languages);
        $languagesToAdd = [];
        foreach($languages as $language){

            if($checkLanguage = \App\Language::where('name', $language)->first()) {
                $languagesToAdd[] = $checkLanguage->id;
            } else {
                $newLanguage = new \App\Language;
                $newLanguage->name = $language;
                $newLanguage->save();
                $languagesToAdd[] = $newLanguage->id;
            }

            $user->languages()->syncWithoutDetaching($languagesToAdd);
        }

        if($user->save()) {
            return redirect()->to('/profile/'.$user->id);
        } else {
            return back()->withInput(\Input::all());
        }

    }

    public function showProfile($id) {
        if($user = \App\User::find($id)){
            $attributes = [
                'user'=>$user,
                'margin'=>'margin-top-20'
            ];
            // controllo se l'utente loggato è un locatore
            if(\Auth::user()->houses()->count()) {
                // controllo se l'utente in questione ha richieste in sospeso per una delle case dell'utente loggato
                foreach(\Auth::user()->houses as $house) {
                    if($house->hasUserPending($id)) {
                        $attributes['pendingRequestHouse'] = $house;
                        $attributes['pendingRequestRoom'] = $user->rooms()->where('house_id', $house->id)->first();
                    } else if($house->hasUser($id)) {
                        $attributes['livingHouse'] = $house;                   
                    }
                }
            }
            return view('profile.show',$attributes);
        } else {
            return view('404');
        }
    }

    public function showCompletePersonalInfoForm() {
        return view('profile.completePersonalInfo',[
            'user'=>\Auth::user()
        ]);
    }

    public function completePersonalInfo(Request $request) {

        $validatorRules = [
            'gender' => 'required',
            'living_city' => 'required_if:living_city_required,true',
            'born_city' => 'required_if:born_city_required,true',
            'telephone' => 'max:20'
        ];

        $validatorMessages = [
            'gender.required' => 'Inserisci il tuo genere',
            'living_city.required_if' => 'Inserisci la tua città di residenza',
            'born_city.required_if' => 'Inserisci la tua città di nascita',
            'telephone.max' => 'Il numero non risulta valido'
        ];

        if(\Auth::user()->birthday == '0000-01-01') {
            $validatorRules['day'] = 'required|integer';
            $validatorRules['month'] = 'required|integer';
            $validatorRules['year'] = 'required|integer';
            $validatorMessages['day.required'] = 'Inserisci la tua data di nascita';
            $validatorMessages['month.required'] = 'Inserisci la tua data di nascita';
            $validatorMessages['year.required'] = 'Inserisci la tua data di nascita';
            $validatorMessages['day.ineger'] = 'Inserisci la tua data di nascita';
            $validatorMessages['month.ineger'] = 'Inserisci la tua data di nascita';
            $validatorMessages['year.ineger'] = 'Inserisci la tua data di nascita';
        }

        if($request->degree_course != ""){
            $validatorRules['university'] = 'required';
            $validatorMessages['university.required'] = 'Per poter inserire il corso di studi è necessario definire anche la relativa Università';
        }
        
        $validatedData = $request->validate($validatorRules, $validatorMessages);

        $user = \Auth::user();
        $user->gender = $request->gender;

        if(\Auth::user()->birthday == '0000-01-01') {
            if(\Carbon\Carbon::create($request->year, $request->month, $request->day) > \Carbon\Carbon::now()->subYears(18)) {
                return back()->withErrors(['Inserisci una data di nascita valida']);
            }

            $user->birthday = \Carbon\Carbon::create($request->year, $request->month, $request->day)->format('Y-m-d');
        }
        // controllo se le città esistono già
        if($request->living_city){
            if(!$livingCity = \App\City::where('text', $request->living_city)->first()) {
                $city = \Geocoder::getCoordinatesForAddress($request->living_city);
                $livingCity = new \App\City;
                $livingCity->text = $city['formatted_address'];
                $livingCity->latitude = $city['lat'];
                $livingCity->longitude = $city['lng'];
                $livingCity->save();
            }
            $user->living_city_id = $livingCity->id;
        }

        if($request->born_city){
            if(!$bornCity = \App\City::where('text',$request->born_city)->first()) {
                $city = \Geocoder::getCoordinatesForAddress($request->born_city);
                $bornCity = new \App\City;
                $bornCity->text = $city['formatted_address'];
                $bornCity->latitude = $city['lat'];
                $bornCity->longitude = $city['lng'];
                $bornCity->save();
            }

            $user->born_city_id = $bornCity->id;
        }

        if($request->telephone != "") $user->telephone = $request->telephone;

        if($request->university !== "") $user->university = $request->university;
       
        if($request->degree_course !== "") $user->degree_course = $request->degree_course;

        if($request->job !== "") $user->job = $request->job;

        if($request->description !== "") $user->description = $request->description;

        
        if($user->save()) {
            return redirect()->to('/complete-signup/interests/');
        } else {
            return back()->withInput(\Input::all());
        }
    }

    public function showInterestsForm() {
        return view('profile.interestsForm');
    }

    public function showHouse() {

        $roomUser = \App\RoomUser::where('room_id',\Auth::user()->livingRooms()->first()->id)->where('user_id',\Auth::user()->id)->orderBy('created_at', 'desc')->first();

        return view('house', [
            'house' => $roomUser->room->house,
            'room_user_id' => $roomUser->id,
            'exited' => $roomUser->stop,
            'room_id' => $roomUser->room->id
        ]);
    }

    public function saveInterests(Request $request){

        $interests = explode(",",$request->interests);
        $interestsToAdd = [];
        foreach($interests as $interest){

            \Log::info($interest);

            if($checkInterest = \App\Interest::where('name', $interest)->first()) {
                $interestsToAdd[] = $checkInterest->id;
            } else {
                $newInterest = new \App\Interest;
                $newInterest->name = $interest;
                $newInterest->save();
                $interestsToAdd[] = $newInterest->id;
            }

            \Auth::user()->interests()->syncWithoutDetaching($interestsToAdd);
        }

        $languages = explode(",",$request->languages);
        $languagesToAdd = [];
        foreach($languages as $language){

            \Log::info($language);

            if($checkLanguage = \App\Language::where('name', $language)->first()) {
                $languagesToAdd[] = $checkLanguage->id;
            } else {
                $newLanguage = new \App\Language;
                $newLanguage->name = $language;
                $newLanguage->save();
                $languagesToAdd[] = $newLanguage->id;
            }

            \Auth::user()->languages()->syncWithoutDetaching($languagesToAdd);
        }

        \Auth::user()->signup_complete = true;
        \Auth::user()->save();
        return redirect()->to('home');
    }

    public function pendingRequests() {
        return view('profile.pendingRequests', [
            'requests' => \Auth::user()->pendingRequests
        ]);
    }
}
