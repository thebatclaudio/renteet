<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $appends = ['url'];

    public function owner() {
        return $this->belongsTo('App\User');
    }

    public function rooms() {
        return $this->hasMany('App\Room');
    }

    public function photos() {
        return $this->hasMany('App\Photo');
    }

    public function services() {
        return $this->belongsToMany('App\Service', 'houses_services')->withPivot('quantity');
    }

    public function getBedsAttribute($value) {
        return $this->rooms()->sum("beds");
    }

    public function getPreviewImageUrlAttribute() {
        if($this->photos->count()){
            $fileName = $this->photos->first()->file_name;
            return \URL::to('/images/houses/'.$this->id.'/'.$fileName);
        } else {
            // TODO: creare immagine placeholder
            return 'data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==';
        }

    }

    public function hasUser($id) {
        foreach($this->rooms as $room) {
            if($room->hasUser($id)) {
                return true;
            }
        }

        return false;
    }

    public function hasUserPending($id) {
        foreach($this->rooms as $room) {
            if($room->hasUserPending($id)) {
                return true;
            }
        }

        return false;        
    }

    public function getUrlAttribute() {
        return \URL::to('/rent/'.$this->id);
    }
}
