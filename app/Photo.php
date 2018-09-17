<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = "houses_photos";
    protected $appends = ['image_url'];

    public function getImageUrlAttribute(){
        return url('/images/houses/'.$this->house_id.'/'.$this->file_name.'-1920.jpg');
    }

    public function house() {
        return $this->belongsTo('App\House');
    }
}
