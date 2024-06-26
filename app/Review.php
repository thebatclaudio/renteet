<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [ 'title', 'text', 'rate', 'from_user_id', 'to_user_id', 'lessor', 'room_user_id', 'tenant' ];

    public function fromUser() {
        return $this->belongsTo('App\User', 'from_user_id');
    }

    public function toUser() {
        return $this->belongsTo('App\User', 'to_user_id');
    }

    public function roomUser(){
        return $this->belongsTo('App\RoomUser','room_user_id');
    }
}
