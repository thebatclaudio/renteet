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
            return view('profile.show')->withUser($user);
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
            'born_city' => 'required'
        ]);

        $user = \Auth::user();
        $user->gender = $request->gender;
        $user->living_city = $request->living_city;
        $user->born_city = $request->born_city;
        
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
