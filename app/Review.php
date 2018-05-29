<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [ 'title', 'text', 'rate', 'from_user_id', 'to_user_id', 'lessor' ];

    public function fromUser() {
        return $this->belongsTo('App\User', 'from_user_id');
    }

    public function toUser() {
        return $this->belongsTo('App\User', 'to_user_id');
    }
}
