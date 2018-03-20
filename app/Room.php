<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function house() {
        return $this->belongsTo('App\House');
    }

    public function users() {
        return $this->belongsToMany('App\User')->withPivot('accepted_by_owner', 'interested');
    }

    public function acceptedUsers() {
        return $this->belongsToMany('App\User')->withPivot('accepted_by_owner', 'interested')->where('accepted_by_owner', true);
    }

    public function pendingUsers() {
        return $this->belongsToMany('App\User')->withPivot('accepted_by_owner', 'interested')->where('accepted_by_owner', false);
    }

    public function hasUser($id) {
        $count = $this->belongsToMany('App\User')->where('user_id', $id)->count();
        return !!$count;
    }

    public function hasUserPending($id) {
        $count = $this->belongsToMany('App\User')->where('user_id', $id)->where('accepted_by_owner', 0)->count();
        return !!$count;
    }
}
