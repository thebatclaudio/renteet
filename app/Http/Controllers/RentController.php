<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\House;
use App\Room;
use App\RoomUser;
use App\Conversation;
use \App\Events\AdhesionToHouse;
use \App\Events\AdhesionAcceptance;
use \App\Events\ExitFromHouse;
use \App\Events\RemovedFromHouse;

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

            // conto gli utenti presenti nella stanza nel giorno di inizio soggiorno
            $currentUsers = $room->acceptedUsers()->where(function($query) use($request){
                return $query->whereNull('stop')
                    ->orWhere('available_from', '>=', $request->startDate);
            })->count();
            if($currentUsers < $room->beds) {
                // controllo se l'utente è il proprietario
                if($room->house->owner_id != \Auth::user()->id){
                    // allego l'utente alla casa
                    $room->users()->attach(\Auth::user()->id, [
                        'accepted_by_owner' => $room->house->auto_accept,
                        'interested' => false,
                        'start' => $request->startDate,
                        'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
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

                // conto gli utenti presenti nella stanza nel giorno di inizio soggiorno
                $currentUsers = $room->acceptedUsers()->where(function($query) use($request){
                    return $query->whereNull('stop')
                        ->orWhereNull('available_from');
                })->count();

                if($currentUsers < $room->beds) {
                    // allego l'utente alla casa
                    $roomUser = RoomUser::where('user_id', $user)->where('room_id', $room->id)->where('accepted_by_owner', false)->orderBy('created_at', 'DESC')->first();
                    if($roomUser) {
                        $roomUser->accepted_by_owner = true;

                        if($roomUser->start == \Carbon\Carbon::now()->format('Y-m-d')){
                            $conversation = Conversation::where('house_id',$room->house->id)->first();
                            $conversation->users()->attach($user);
                        }

                        // lancio l'evento per inviare la notifica push
                        event(new AdhesionAcceptance($user, $room->house->id));
                        // creo la notifica nel db
                        User::find($user)->notify(new \App\Notifications\AdhesionAcceptance($user, $room->house->id));

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
   
    public function exitFromHouse($id, Request $request) {
        $roomUser = RoomUser::where([
            'user_id' => \Auth::user()->id, 
            'room_id' => $id,
            'accepted_by_owner' => true,
            'stop' => null
        ])->first();
        
        if($roomUser) {
            $roomUser->stop = $request->stopDate;
            if($roomUser->save()) {
                event(new ExitFromHouse(\Auth::user()->id, $roomUser->room->house->id));
                
                // creo la notifica nel db
                User::find($roomUser->room->house->owner->id)->notify(new \App\Notifications\ExitFromHouse(\Auth::user()->id, $roomUser->room->house->id));
                
                if($request->stopDate == \Carbon\Carbon::now()->format('Y-m-d')){
                    $conversation = Conversation::where('house_id',$roomUser->house->id)->first();
                    $conversation->users()->detach($user);
                }

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

    public function selectAvailableDate($room, $user, Request $request){
        $roomUser = RoomUser::where([
            'user_id' => $user, 
            'room_id' => $room
        ])->whereNotNull('stop')->first();
        
        if($roomUser){
            if(Room::find($room)->house->owner_id === \Auth::user()->id){
                $roomUser->available_from = $request->available_from;
                if($roomUser->save()){
                    return response()->json([
                        'status' => 'OK'
                    ]);
                }else{
                    return response()->json([
                        'status' => 'KO'
                    ]);       
                }
            }else{
                return response()->json([
                    'status' => 'KO'
                ]);
            }
        }else{
            return response()->json([
                'status' => 'KO'
            ]);
        }
    }

    public function remove($room, $user, Request $request){
       // \Log::info($user." ".$room);
        $roomUser = RoomUser::where([
            'user_id' => $user, 
            'room_id' => $room
        ])->where('stop',NULL)->where('accepted_by_owner',true);
       // \Log::info(\Carbon\Carbon::now()->format('Y-m-d'));
            if($roomUser->count()){
                $currentRoom = Room::find($room);
                if($currentRoom->house->owner_id === \Auth::user()->id){
                    $roomUser = $roomUser->first();
                    $roomUser->stop = $request->stop;
                    if($roomUser->save()){
                        event(new RemovedFromHouse($user, $currentRoom->house->id));

                        // creo la notifica nel db
                        User::find($user)->notify(new \App\Notifications\RemovedFromHouse($user, $currentRoom->house->id));

                        if($request->stop == \Carbon\Carbon::now()->format('Y-m-d')){
                            $conversation = Conversation::where('house_id',$currentRoom->house->id)->first();
                            $conversation->users()->detach($user);
                        }
                        
                        return response()->json([
                            'status' => 'OK'
                        ]);
                    }else{
                        return response()->json([
                            'status' => 'KO'
                        ]);
                    }
                }else{
                    return response()->json([
                        'status' => 'KO'
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 'KO'
                ]);
            }
    }
}
