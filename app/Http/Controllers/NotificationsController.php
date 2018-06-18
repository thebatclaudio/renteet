<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function ajaxIndex() {
        $notifications = [];
        foreach(\Auth::user()->unreadNotifications()->orderBy('created_at', 'desc')->limit(5)->get() as $notification) {
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

    public function index() {
        $notifications = [];
        foreach(\Auth::user()->unreadNotifications()->orderBy('created_at', 'desc')->limit(20)->get() as $notification) {
            switch($notification->type) {
                case "App\Notifications\AdhesionToHouse":
                    if($user = \App\User::find($notification->data['user_id']) AND $house = \App\House::find($notification->data['house_id'])) {
                        $new_notification = new \stdClass();
                        $new_notification->image = $user->profile_pic;
                        $new_notification->text = $user->first_name." ".$user->last_name." ti ha inviato una richiesta d'adesione per l'appartamento ".$house->name;
                        $new_notification->url = route("user.profile", $notification->data['user_id']);
                        $new_notification->date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->format('d M Y H:i');
                        $new_notification->user = $user;
                        $notifications[] = $new_notification;
                    }
                break;
            }
        }

        return view('profile.notifications', [
            'notifications' => $notifications
        ]);
    }
}
