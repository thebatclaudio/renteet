<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{

    protected $fillable = ['user_id','type_id','message'];

    public function type() {
        return $this->belongsTo('App\SupportType');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }


}
