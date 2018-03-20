<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    public function owner() {
        return $this->belongsTo('App\User');
    }

    public function rooms() {
        return $this->hasMany('App\Room');
    }

    public function getBedsAttribute($value) {
        return $this->rooms()->sum("beds");
    }

    public function getPreviewImageUrlAttribute() {
        return \URL::to('/images/houses/1.jpg');
    }

    public function hasUser($id) {
        foreach($this->rooms as $room) {
            if($room->hasUser($id)) {
                return true;
            }
        }

        return false;
    }
}
