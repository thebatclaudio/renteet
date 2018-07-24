<?php

namespace App\Http\Controllers;

use App\Review;
use App\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function rateUser($id,Request $request) {
        $validatedData = $request->validate([
            'rating' => 'required',
            'message' => 'required',
            'room_user_id' => 'required'
        ]);

        if($roomUser = \App\RoomUser::find($request->room_user_id)){
            if($roomUser->user_id === \Auth::user()->id and $roomUser->accepted_by_owner){
                if($id == 'house'){
                    Review::create([
                        'text' => $request->message,
                        'rate' => $request->rating + 1,
                        'from_user_id' => \Auth::user()->id,
                        'to_user_id' => \App\House::find($roomUser->room->house_id)->owner->id,
                        'room_user_id' => $request->room_user_id,
                        'lessor' => true
                    ]);
                    return response()->json([
                        'status'=>'OK'
                    ]);
                }else{
                    if(\App\RoomUser::where('user_id',$id)
                        ->whereIn('room_id',$roomUser->room->house->rooms->pluck('id'))
                        ->where(function($query) use($roomUser){
                            $query->whereBetween('start',[$roomUser->start,$roomUser->stop])
                                ->orWhereBetween('stop',[$roomUser->start,$roomUser->stop]);
                        })->count()){
                        Review::create([
                            'text' => $request->message,
                            'rate' => $request->rating + 1,
                            'from_user_id' => \Auth::user()->id,
                            'to_user_id' => $id,
                            'room_user_id' => $request->room_user_id,
                            'lessor' => false
                        ]);
                        return response()->json([
                            'status'=>'OK'
                        ]);
                    }else{
                        return response()->json([
                            'status'=>'KO1'
                        ]);
                    }
                }
            }
        }
        return response()->json([
            'status'=>'KO2'
        ]);
    }
}
