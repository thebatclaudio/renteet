<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function ajaxIndex() {
        $notifications = [];
        foreach(\Auth::user()->notifications()->orderBy('created_at', 'desc')->limit(5)->get() as $notification) {
            switch($notification->type) {
                case "App\Notifications\AdhesionToHouse":
                    if($user = \App\User::find($notification->data['user_id']) AND $house = \App\House::find($notification->data['house_id'])) {
                        $new_notification = new \stdClass();
                        $new_notification->image = $user->profile_pic;
                        $new_notification->text = $user->first_name." ".$user->last_name." ti ha inviato una richiesta d'adesione per l'appartamento ".$house->name." dal ".\Carbon\Carbon::createFromFormat('Y-m-d', $user->rooms()->where('house_id', $house->id)->first()->pivot->start)->format('d/m/Y');
                        $new_notification->url = route("user.profile", $notification->data['user_id']);
                        $new_notification->created_at = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->timestamp * 1000;
                        if($notification->read_at !== null){
                            $new_notification->read_at = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->read_at)->timestamp * 1000;
                        }else{
                            $new_notification->read_at = $notification->read_at;
                        }
                        $notifications[] = $new_notification;
                    }
                break;
                
                case "App\Notifications\AdhesionAcceptance":
                    if($user = \App\User::find($notification->data['user_id']) AND $owner = \App\User::find($notification->data['owner_id']) AND $house = \App\House::find($notification->data['house_id'])) {
                        $new_notification = new \stdClass();
                        $new_notification->image = $owner->profile_pic;
                        $new_notification->text = $owner->first_name." ".$owner->last_name." ha accetato la tua richiesta d'adesione per l'appartamento ".$house->name." dal ".\Carbon\Carbon::createFromFormat('Y-m-d', $user->rooms()->where('house_id', $house->id)->first()->pivot->start)->format('d/m/Y');
                        $new_notification->url = $house->url;
                        $new_notification->created_at = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->timestamp * 1000;
                        if($notification->read_at !== null){
                            $new_notification->read_at = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->read_at)->timestamp * 1000;
                        }else{
                            $new_notification->read_at = $notification->read_at;
                        }
                        $notifications[] = $new_notification;
                    }
                break;

                case "App\Notifications\ReviewReceived":
                    if($user = \App\User::find($notification->data['user_id']) AND $review = \App\Review::find($notification->data['review_id'])) {
                        $new_notification = new \stdClass();
                        $new_notification->image = $user->profile_pic;
                        $new_notification->text = $user->first_name." ".$user->last_name." ti ha lasciato una recensione";
                        $new_notification->url = $user->profile_url;
                        
                        if($review->lessor == true){
                            if($house = \App\House::find($notification->data['house_id'])){
                                $new_notification->text = $new_notification->text." per l'appartamento ".$house->name;
                                $new_notification->url = $house->url;
                            }
                        }

                        $new_notification->created_at = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->timestamp * 1000;
                        if($notification->read_at !== null){
                            $new_notification->read_at = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->read_at)->timestamp * 1000;
                        }else{
                            $new_notification->read_at = $notification->read_at;
                        }
                        $notifications[] = $new_notification;
                    }
                break;


            }
            $notification->read_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $notification->save();
        }

        return response()->json($notifications);
    }

    public function index() {
        $notifications = [];
        foreach(\Auth::user()->notifications()->orderBy('created_at', 'desc')->limit(20)->get() as $notification) {
            switch($notification->type) {
                case "App\Notifications\AdhesionToHouse":
                    if($user = \App\User::find($notification->data['user_id']) AND $house = \App\House::find($notification->data['house_id'])) {
                        $new_notification = new \stdClass();
                        $new_notification->image = $user->profile_pic;
                        $new_notification->text = $user->first_name." ".$user->last_name." ti ha inviato una richiesta d'adesione per l'appartamento ".$house->name." dal ".$user->rooms()->where('house_id', $house->id)->first()->pivot->start;
                        $new_notification->url = route("user.profile", $notification->data['user_id']);
                        $new_notification->date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->format('d M Y H:i');
                        $new_notification->user = $user;
                        $notifications[] = $new_notification;
                    }
                break;

                case "App\Notifications\AdhesionAcceptance":
                    if($user = \App\User::find($notification->data['user_id']) AND $owner = \App\User::find($notification->data['owner_id']) AND $house = \App\House::find($notification->data['house_id'])) {
                        $new_notification = new \stdClass();
                        $new_notification->image = $owner->profile_pic;
                        $new_notification->text = $owner->first_name." ".$owner->last_name." ha accetato la tua richiesta d'adesione per l'appartamento ".$house->name." dal ".\Carbon\Carbon::createFromFormat('Y-m-d', $user->rooms()->where('house_id', $house->id)->first()->pivot->start)->format('d/m/Y');
                        $new_notification->url = $house->url;
                        $new_notification->date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->format('d M Y H:i');
                        $new_notification->user = $user;
                        $notifications[] = $new_notification;
                    }
                break;

                case "App\Notifications\ReviewReceived":
                    if($user = \App\User::find($notification->data['user_id']) AND $review = \App\Review::find($notification->data['review_id'])) {
                        $new_notification = new \stdClass();
                        $new_notification->image = $user->profile_pic;
                        $new_notification->text = $user->first_name." ".$user->last_name." ti ha lasciato una recensione";
                        $new_notification->url = $user->profile_url;
                        
                        if($review->lessor == true){
                            if($house = \App\House::find($notification->data['house_id'])){
                                $new_notification->text = $new_notification->text." per l'appartamento ".$house->name;
                                $new_notification->url = $house->url;
                            }
                        }

                        $new_notification->date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->format('d M Y H:i');
                        $new_notification->user = $user;

                        $notifications[] = $new_notification;
                    }
                break;
            }
            $notification->read_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $notification->save();
        }

        return view('profile.notifications', [
            'notifications' => $notifications
        ]);
    }
}
