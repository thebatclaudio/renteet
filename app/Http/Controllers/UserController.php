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

            // controllo se l'utente loggato è un locatore
            if(\Auth::user()->houses()->count()) {
                // controllo se l'utente in questione ha richieste in sospeso per una delle case dell'utente loggato
                foreach(\Auth::user()->houses as $house) {
                    if($house->hasUserPending($id)) {
                        return view('profile.show', [
                            'user' => $user,
                            'pendingRequestHouse' => $house,
                            'pendingRequestRoom' => $user->rooms()->where('house_id', $house->id)->first(),
                            'margin' => 'margin-house-topbar'
                        ]);
                    } else if($house->hasUser($id)) {
                        return view('profile.show', [
                            'user' => $user,
                            'livingHouse' => $house,
                            'margin' => 'margin-house-topbar'
                        ]);                      
                    }
                }
            }

            return view('profile.show', [
                'user' => $user,
                'margin' => 'margin-top-20'
            ]);
        } else {
            return view('404');
        }
    }

    public function showCompletePersonalInfoForm() {
        return view('profile.completePersonalInfo');
    }

    public function completePersonalInfo(Request $request) {
        
        $validatedData = $request->validate([
            'gender' => 'required',
            'living_city' => 'required',
            'living_city_id' => 'required',
            'born_city' => 'required',
            'born_city_id' => 'required',
        ]);

        $user = \Auth::user();
        $user->gender = $request->gender;
        // controllo se le città esistono già
        if(!$livingCity = \App\City::where('google_place_id', $request->living_city_id)->first()) {
            $livingCity = new \App\City;
            $livingCity->google_place_id = $request->living_city_id;
            $livingCity->text = $request->living_city;
            $livingCity->latitude = $request->living_city_lat;
            $livingCity->longitude = $request->living_city_lng;
            $livingCity->save();
        }

        $user->living_city_id = $livingCity->id;

        if(!$bornCity = \App\City::where('google_place_id', $request->born_city_id)->first()) {
            $bornCity = new \App\City;
            $bornCity->google_place_id = $request->born_city_id;
            $bornCity->text = $request->born_city;
            $bornCity->latitude = $request->born_city_lat;
            $bornCity->longitude = $request->born_city_lng;
            $bornCity->save();
        }

        $user->born_city_id = $bornCity->id;
        
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
        return view('house', [
            'house' => \App\Room::find(\App\RoomUser::where('user_id', Auth::user()->id)->first()->room_id)->house
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

        return redirect()->to('home');
    }
}
