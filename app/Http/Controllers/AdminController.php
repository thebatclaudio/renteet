<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\House;
use App\Room;
class AdminController extends Controller
{
    public function house($id) {
        if($house = House::find($id)) {
            if($house->owner->id === \Auth::user()->id) {
                return view('admin.house')->withHouse($house);
            }
        }
    }

    public function newHouseWizardStepOne(){
        return view('admin.wizard.one', [
            'houseTypes' => \App\HouseType::all()
        ]);
    }

    public function newHouseWizardStepOneSave(Request $request){
        $validatedData = $request->validate([
            'tipologia' => 'required',
            'address' => 'required',
            'address_lat' => 'required',
            'address_lng' => 'required',
            'address_name' => 'required',
            'address_number' => 'required',
            'address_city' => 'required',
            'bedrooms' => 'required',
            'rooms' => 'required'
        ]);

        //TODO: l'ideale sarebbe gestirlo con il place_id di google maps
        $house = new House;
        $house->name = $request->address;
        $house->street_name = $request->address_name;
        $house->number = $request->address_number;
        $house->city = $request->address_city;
        $house->latitude = $request->address_lat;
        $house->longitude = $request->address_lng;
        $house->owner_id = \Auth::user()->id;
        if($house->save()) {
            foreach($request->rooms as $roomBeds){
                $room = new Room;
                $room->beds = $roomBeds;
                $room->house_id = $house->id;
                $room->save();
            }
        }

        return redirect()->route('admin.house.wizard.two');
    }


    public function newHouseWizardStepTwo(){
        return view('admin.wizard.two');
    }

    public function newHouseWizardStepThree(){
        return view('admin.wizard.three');
    }

    public function newHouseWizardStepFour(){
        return view('admin.wizard.four');
    }
}
