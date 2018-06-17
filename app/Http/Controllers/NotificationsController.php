<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function ajaxIndex() {
        $notifications = [];
        foreach(\Auth::user()->unreadNotifications()->limit(5)->get() as $notification) {
            switch($notification->type) {
                case "App\Notifications\AdhesionToHouse":
                    if($user = \App\User::find($notification->data['user_id']) AND $house = \App\House::find($notification->data['house_id'])) {
                        $new_notification = new \stdClass();
                        $new_notification->image = $user->profile_pic;
                        $new_notification->text = $user->first_name." ".$user->last_name." ti ha inviato una richiesta d'adesione per l'appartamento ".$house->name;
                        $new_notification->url = route("user.profile", $notification->data['user_id']);
                        $notifications[] = $new_notification;
                    }
                break;
            }
        }

        return response()->json($notifications);
    }
}
