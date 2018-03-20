<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\House;
use App\Room;
use App\RoomUser;

class RentController extends Controller
{
    public function getHouse($house_id){
        return view('rent', [
            'house' => House::find($house_id)
        ]);
    }

    public function rentHouse($id, Request $request){
        // controllo se esiste la stanza
        if($room = Room::find($id)){
            // controllo se ci sono posti liberi
            if($room->acceptedUsers()->count() < $room->beds) {
                // allego l'utente alla casa
                $room->users()->attach(\Auth::user()->id, [
                    'accepted_by_owner' => false,
                    'interested' => false
                ]);
                return response()->json([
                    'status' => 'OK'
                ]);
            } else {
                return response()->json([
                    'status' => 'KO'
                ]);                
            }
        } else {
            return response()->json([
                'status' => 'KO'
            ]);
        }
    }

    public function allowUser($room, $user, Request $request){
        // controllo se esiste la stanza
        if($room = Room::find($room)){
            //controllo se l'utente loggato è il proprietario
            if($room->house->owner->id == \Auth::user()->id) {
                // controllo se ci sono posti liberi
                if($room->acceptedUsers()->count() < $room->beds) {
                    // allego l'utente alla casa
                    $roomUser = RoomUser::where('user_id', $user)->where('room_id', $room->id)->first();
                    if($roomUser) {
                        $roomUser->accepted_by_owner = true;
                        if($roomUser->save()) {
                            return response()->json([
                                'status' => 'OK'
                            ]);
                        } else {
                            return response()->json([
                                'status' => 'KO'
                            ]);                            
                        }
                    } else {
                        return response()->json([
                            'status' => 'KO'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 'KO'
                    ]);                
                }
            } else {
                return response()->json([
                    'status' => 'KO'
                ]);                
            }
        } else {
            return response()->json([
                'status' => 'KO'
            ]);
        }
    }
}
