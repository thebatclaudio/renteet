<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\House;
use App\Room;
use App\RoomUser;
use \App\Events\AdhesionToHouse;
use \App\Events\AdhesionAcceptance;

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
                // controllo se l'utente è il proprietario
                if($room->house->owner_id != \Auth::user()->id){
                    // allego l'utente alla casa
                    $room->users()->attach(\Auth::user()->id, [
                        'accepted_by_owner' => $room->house->auto_accept,
                        'interested' => false,
                        'start' => $request->startDate
                    ]);

                    // lancio l'evento per inviare la notifica push
                    event(new AdhesionToHouse(\Auth::user()->id, $room->house->id, $room->house->auto_accept));

                    $room->house->owner->notify(new \App\Notifications\AdhesionToHouse(\Auth::user()->id, $room->house->id, $room->house->auto_accept));
                    
                    if($room->house->auto_accept){
                        return response()->json([
                            'status' => 'OK'
                        ]);
                    } else {
                        return response()->json([
                            'status' => 'WAITING'
                        ]);                        
                    }
                }
            }
        }
        
        return response()->json([
            'status' => 'KO'
        ]);
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

                        // lancio l'evento per inviare la notifica push
                        event(new AdhesionAcceptance($user, $room->house->id));

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
   
    public function exitFromHouse($id) {
        $room = \Auth::user()->rooms()->where('room_id', $id)->wherePivot('start', '<=', \Carbon\Carbon::now()->format('Y-m-d'))->wherePivot('stop', NULL);
        if($room->count()) {
            $roomUser = RoomUser::where([
                'user_id' => \Auth::user()->id, 
                'room_id' => $room->first()->id
            ])->first();
            $roomUser->stop = \Carbon\Carbon::now()->format('Y-m-d');
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
    }
}
