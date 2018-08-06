<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showEditProfileForm() {
        return view('profile.edit');
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
        
        $validatedData = $request->validate([
            'gender' => 'required',
            'living_city' => 'required_if:living_city_required,true',
            'born_city' => 'required_if:born_city_required,true',
            'description' => 'required',
        ]);

        $user = \Auth::user();
        $user->gender = $request->gender;
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

        if($request->university !== "") $user->university = $request->university;
       
        if($request->job !== "") $user->job = $request->job;

        $user->description = $request->description;

        
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

        $roomUser = \App\RoomUser::where('room_id',\Auth::user()->livingRooms()->first()->id)->where('user_id',\Auth::user()->id)->first();

        return view('house', [
            'house' => \Auth::user()->livingRooms()->first()->house,
            'room_user_id' => $roomUser->id,
            'exited' => $roomUser->stop
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


        return redirect()->to('home');
    }

    public function pendingRequests() {
        return view('profile.pendingRequests', [
            'requests' => \Auth::user()->pendingRequests
        ]);
    }
}
