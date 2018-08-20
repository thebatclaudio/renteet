<?php

namespace App\Http\Controllers;

use App\Review;
use App\User;
use Illuminate\Http\Request;
use App\Events\ReviewReceived;

class ReviewController extends Controller
{
    public function rateUser($id,Request $request) {
        $validatedData = $request->validate([
            'rating' => 'required',
            'message' => 'required',
            'room_user_id' => 'required'
        ]);

        if($roomUser = \App\RoomUser::find($request->room_user_id)){

            if($request->tenant) {
                // si tratta di una recensione lasciata dal locatore all'inquilino
                // controllo che l'utente sia davvero il proprietario dell'immobile
                if($roomUser->room->house->owner_id == \Auth::user()->id){
                    // controllo che l'utente che sto recensendo è davvero relativo a quel periodo di soggiorno
                    if($roomUser->user_id == $id) {
                        // cafuddo la recensione
                        $newReview = Review::create([
                            'text' => $request->message,
                            'rate' => $request->rating + 1,
                            'from_user_id' => \Auth::user()->id,
                            'to_user_id' => $id,
                            'room_user_id' => $roomUser->id,
                            'lessor' => false,
                            'tenant' => true
                        ]);

                        //lancio l'evento per la notifica push
                        event(new ReviewReceived($id, $newReview->id,\Auth::user()->id,null));

                        //creo notifica db
                        \App\User::find($id)->notify(new \App\Notifications\ReviewReceived($id, $newReview->id,\Auth::user()->id,null));
                        
                        return response()->json([
                            'status'=>'OK'
                        ]);
                    }
                }
            }

            //controllo se user_id in room_user è uguale a quello dell'utente
            if($roomUser->user_id === \Auth::user()->id and $roomUser->accepted_by_owner){
                // se id è house allora la recensione è relativa alla casa
                if($id == 'house'){
                    $to_owner = \App\House::find($roomUser->room->house_id)->owner; 
                    $newReview = Review::create([
                        'text' => $request->message,
                        'rate' => $request->rating + 1,
                        'from_user_id' => \Auth::user()->id,
                        'to_user_id' => $to_owner->id,
                        'room_user_id' => $request->room_user_id,
                        'lessor' => true
                    ]);
                    //lancio l'evento per la notifica push
                    event(new ReviewReceived($to_owner->id, $newReview->id,\Auth::user()->id,$roomUser->room->house_id));

                    //creo notifica nel db
                    $to_owner->notify(new \App\Notifications\ReviewReceived($to_owner->id, $newReview->id,\Auth::user()->id,$roomUser->room->house_id));
                    
                    return response()->json([
                        'status'=>'OK'
                    ]);
                }else{
                    // viceversa è relativa ad un utente
                    $stop = $roomUser->stop ? $roomUser->stop != null : \Carbon\Carbon::now()->format('Y-m-d H:i:s');

                    //controllo quindi che i due utenti abbiano vissuto realmente insieme in quella casa, controllando le intersezioni tra i due periodi di soggiorno
                    if(\App\RoomUser::where('user_id',$id)
                        ->whereIn('room_id',$roomUser->room->house->rooms->pluck('id'))
                        ->where(function($query) use($roomUser,$stop){
                            $query->whereBetween('start',[$roomUser->start,$stop])
                                ->orWhereBetween('stop',[$roomUser->start,$stop])
                                ->orWhere(function($query) use($roomUser,$stop){
                                    return $query->where('start','<=',$roomUser->start)
                                            ->where(function($query) use($roomUser,$stop){
                                                $query->where('stop','>',$roomUser->start)
                                                    ->orWhereNull('stop');
                                            });
                                });
                        })->count()){
                            $newReview = Review::create([
                            'text' => $request->message,
                            'rate' => $request->rating + 1,
                            'from_user_id' => \Auth::user()->id,
                            'to_user_id' => $id,
                            'room_user_id' => $request->room_user_id,
                            'lessor' => false
                        ]);
                        //lancio l'evento per la notifica push
                        event(new ReviewReceived($id, $newReview->id,\Auth::user()->id,null));

                        //creo notifica db
                        \App\User::find($id)->notify(new \App\Notifications\ReviewReceived($id, $newReview->id,\Auth::user()->id,null));
                        
                        return response()->json([
                            'status'=>'OK'
                        ]);
                    }else{
                        return response()->json([
                            'status'=>'KO'
                        ]);
                    }
                }
            }
        }
        return response()->json([
            'status'=>'KO'
        ]);
    }
}
