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
            'renteet_house_address' => 'required',
            'address_lat' => 'required',
            'address_lng' => 'required',
            'address_name' => 'required',
            'address_number' => 'required',
            'address_city' => 'required',
            'bedrooms' => 'required',
            'rooms' => 'required|array|size:bedrooms',
            'prices' => 'required|array|size:bedrooms',
            'mq' => 'required',
            'bathrooms' => 'required'
        ], [
            'address_lat.required' => 'Inserisci un indirizzo valido',
            'address_lng.required' => 'Inserisci un indirizzo valido',
            'address_name.required' => 'Inserisci un indirizzo valido',
            'address_number.required' => 'Inserisci un indirizzo valido',
            'address_city.required' => 'Inserisci un indirizzo valido',
            'renteet_house_address.required' => 'Inserisci un indirizzo valido',
            'tipologia.required' => 'Inserisci una tipologia',
            'bedrooms.required' => 'Inserisci il numero di stanze da letto',
            'rooms.required' => 'Inserisci il numero di posti letto per ogni stanza',
            'prices.required' => 'Inserisci il prezzo per posto letto per ogni stanza',
            'rooms.array' => 'Inserisci il numero di posti letto per ogni stanza',
            'prices.array' => 'Inserisci il prezzo per posto letto per ogni stanza',
            'rooms.size' => 'Inserisci il numero di posti letto per ogni stanza',
            'prices.size' => 'Inserisci il prezzo per posto letto per ogni stanza',
            'mq.required' => 'Inserisci la grandezza del tuo immobile',
            'bathrooms.required' => 'Inserisci il numero di bagni',
        ]);

        $house = new House;
        $house->name = $request->renteet_house_address;
        $house->street_name = $request->address_name;
        $house->number = $request->address_number;
        $house->city = $request->address_city;
        $house->latitude = $request->address_lat;
        $house->longitude = $request->address_lng;
        $house->mq = $request->mq;
        $house->bathrooms = $request->bathrooms;
        $house->owner_id = \Auth::user()->id;
        $house->last_step = 1;
        $house->type_id = $request->tipologia;
        if($house->save()) {
            if(count($request->rooms) == count($request->prices)){
                foreach($request->rooms as $key => $roomBeds){
                    $room = new Room;
                    $room->beds = $roomBeds;
                    $room->house_id = $house->id;
                    $room->bed_price = $request->prices[$key];
                    $room->save();
                }
            }
        }

        mkdir(public_path('images/houses/'.$house->id));

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
                if($request->input('services')) {
                    foreach($request->input('services') as $service) {
                        if(isset($request->input('servicesQuantity')[$service])) {
                            $house->services()->attach([$service => ['quantity' => $request->input('servicesQuantity')[$service]]]);
                        } else {
                            $house->services()->attach($service);
                        }
                        
                    }
                }

                $house->last_step = 2;
                
                if($request->input("other_services")) {
                    $house->other_services = $request->input("other_services");
                }

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
        request()->validate([
            'file' => 'required|image|mimes:jpeg,jpg',
        ]);

        if($house = House::find($request->input('id'))) {
            if($house->owner->id === \Auth::user()->id) {
                $timestamp = \Carbon\Carbon::now()->timestamp.rand(0,99999);
                $imageName = $timestamp;

                \Image::make($request->file)->resize(1920, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/houses/'.$house->id). "/". $timestamp."-1920.jpg");

                \Image::make($request->file)->resize(320, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/houses/'.$house->id). "/". $timestamp."-320.jpg");

                \Image::make($request->file)->resize(670, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/houses/'.$house->id). "/". $timestamp."-670.jpg");

                \Image::make($request->file)->resize(220, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/houses/'.$house->id). "/". $timestamp."-220.jpg");

                \Image::make($request->file)->resize(490, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/houses/'.$house->id). "/". $timestamp."-490.jpg");

                \Image::make($request->file)->resize(300, 300)->save(public_path('images/houses/'.$house->id). "/". $timestamp."-thumb.jpg");

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
            'gender' => 'required',
        ]);

        if($house = House::find($request->input('id'))) {
            if($house->owner->id === \Auth::user()->id) {
                $house->auto_accept = false;
                $house->gender = $request->input('gender');
                $house->notice_months = 3;
                $house->last_step = 4;
                $house->save();

                $conversation = new \App\Conversation;
                $conversation->house_id = $house->id;
                $conversation->save();

                $conversationUser = new \App\ConversationUser;
                $conversationUser->conversation_id = $conversation->id;
                $conversationUser->user_id = $house->owner->id;
                $conversationUser->save();

                return redirect()->route('admin.dashboard');
            }
        }
        
        return redirect()->back();
    }
}
