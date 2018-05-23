<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\House;
use App\Room;
use App\Photo;
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
        $house->last_step = 1;
        if($house->save()) {
            foreach($request->rooms as $roomBeds){
                $room = new Room;
                $room->beds = $roomBeds;
                $room->house_id = $house->id;
                $room->save();
            }
        }

        return redirect()->route('admin.house.wizard.two', ['id' => $house->id]);
    }


    public function newHouseWizardStepTwo(Request $request){
        return view('admin.wizard.two', [
            'servicesQuantity' => \App\Service::quantityNeeded(true)->get(),
            'servicesWithoutQuantity' => \App\Service::quantityNeeded(false)->get(),
            'id' => $request->input('id')
        ]);
    }

    public function newHouseWizardStepTwoSave(Request $request){
        if($house = House::find($request->input('id'))) {
            if($house->owner->id === \Auth::user()->id) {
                foreach($request->input('services') as $service) {
                    if(isset($request->input('servicesQuantity')[$service])) {
                        $house->services()->attach([$service => ['quantity' => $request->input('servicesQuantity')[$service]]]);
                    } else {
                        $house->services()->attach($service);
                    }
                    
                }

                $house->last_step = 2;
                $house->save();

                return redirect()->route('admin.house.wizard.three', ['id' => $house->id]);
            }
        }

        return redirect()->back();
    }

    public function newHouseWizardStepThree(Request $request){
        $validatedData = $request->validate([
            'id' => 'required',
        ]);

        if($house = House::find($request->input('id'))) {
            return view('admin.wizard.three', ['id' => $request->input('id'), 'streetName' => $house->street_name]);
        } else {
            return redirect()->back();
        }
        
    }

    public function newHouseWizardStepThreeUpload(Request $request){
        if($house = House::find($request->input('id'))) {
            if($house->owner->id === \Auth::user()->id) {
                $imageName = request()->file->getClientOriginalName();
                request()->file->move(public_path('images/houses/'.$house->id), $imageName);
                $photo = new Photo;
                $photo->file_name = $imageName;
                $photo->house_id = $house->id;
                $photo->save();

                return response()->json(['uploaded' => '/images/houses/'.$house->id.'/'.$imageName]);
            }
        }
    }

    public function newHouseWizardStepThreeSave(Request $request){
        $validatedData = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'description' => 'required'
        ]);

        if($house = House::find($request->input('id'))) {
            if($house->owner->id === \Auth::user()->id) {
                $house->name = $request->input('name');
                $house->description = $request->input('description');
                $house->last_step = 3;
                $house->save();

                return redirect()->route('admin.house.wizard.four', ['id' => $house->id]);
            }
        }
        
        return redirect()->back();
    }

    public function newHouseWizardStepFour(Request $request){
        return view('admin.wizard.four', ['id' => $request->input('id')]);
    }

    public function newHouseWizardStepFourSave(Request $request){
        $validatedData = $request->validate([
            'id' => 'required',
            'auto_accept' => 'required',
            'gender' => 'required',
            'notice_months' => 'required'
        ]);

        if($house = House::find($request->input('id'))) {
            if($house->owner->id === \Auth::user()->id) {
                $house->auto_accept = $request->input('auto_accept');
                $house->gender = $request->input('gender');
                $house->notice_months = $request->input('notice_months');
                $house->last_step = 4;
                $house->save();

                return redirect()->route('admin.dashboard');
            }
        }
        
        return redirect()->back();
    }
}
