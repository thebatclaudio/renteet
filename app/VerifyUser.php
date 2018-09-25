<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
    protected $table = 'verify_users';

    protected $fillable = [
        'user_id', 'token','counter'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function daysLeftConfirm(){
        $expiredTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->subDays(3);
        $now = \Carbon\Carbon::now();
        return $expiredTime->diffInDays($now);
    }
}
