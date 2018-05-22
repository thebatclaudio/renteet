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
            foreach($request->input('services') as $service) {
                $house->services()->sync([$service => ['quantity' => $request->input('servicesQuantity')[$service]]]);
            }

            return redirect()->route('admin.house.wizard.three', ['id' => $house->id]);
        }

        return redirect()->back();
    }

    public function newHouseWizardStepThree(Request $request){
        return view('admin.wizard.three', ['id' => $request->input('id')]);
    }

    public function newHouseWizardStepThreeSave(Request $request){
        if($house = House::find($request->input('id'))) {
            $imageName = request()->file->getClientOriginalName();
            request()->file->move(public_path('images/houses/'.$house->id), $imageName);
            $photo = new Photo;
            $photo->file_name = $imageName;
            $photo->house_id = $house->id;
            $photo->save();

            return response()->json(['uploaded' => '/images/houses/'.$house->id.'/'.$imageName]);
        }

        //return redirect()->route('admin.house.wizard.four', ['id' => $house->id]);
    }

    public function newHouseWizardStepFour(){
        return view('admin.wizard.four');
    }
}
