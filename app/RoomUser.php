<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RoomUser extends Model
{
    use SoftDeletes;
    protected $table = "room_user";

    public function room(){
        return $this->belongsTo('App\Room');
    }
}
