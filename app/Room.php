<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'bed_price'
    ];

    public function house() {
        return $this->belongsTo('App\House');
    }

    public function users() {
        return $this->belongsToMany('App\User')->whereNull('room_user.deleted_at')->withPivot('accepted_by_owner', 'interested', 'start', 'stop', 'created_at', 'updated_at', 'available_from');
    }

    public function notAvailableBeds(){
        return $this->belongsToMany('App\User')
        ->withPivot('accepted_by_owner', 'interested', 'start', 'stop', 'created_at', 'updated_at', 'available_from')
        ->where('accepted_by_owner', true)
        ->where('available_from','>',\Carbon\Carbon::now()->format('Y-m-d'))
        ->where('stop','<=',\Carbon\Carbon::now()->format('Y-m-d'))
        ->whereNull('room_user.deleted_at');
    }

    public function acceptedUsers() {
        return $this->belongsToMany('App\User')
        ->withPivot('accepted_by_owner', 'interested', 'start', 'stop', 'created_at', 'updated_at', 'available_from')
        ->where('accepted_by_owner', true)
        ->where(function($query){
            $query->where('stop','>=',\Carbon\Carbon::now()->format('Y-m-d'))
            ->orWhereNull('stop');
        })
        ->whereNull('room_user.deleted_at');
    }

    public function previousUsers() {
        return $this->belongsToMany('App\User')
        ->withPivot('accepted_by_owner', 'interested', 'start', 'stop', 'created_at', 'updated_at', 'available_from', 'id')
        ->where('accepted_by_owner', true)
        ->where('stop','<',\Carbon\Carbon::now()->format('Y-m-d'))
        ->whereNull('room_user.deleted_at');
    }

    public function pendingUsers() {
        return $this->belongsToMany('App\User')
            ->withPivot('accepted_by_owner', 'interested', 'start', 'stop', 'created_at', 'updated_at', 'available_from')
            ->where('accepted_by_owner', false)
            ->where('start', '>=',\Carbon\Carbon::now()->format('Y-m-d'))
            ->whereNull('room_user.deleted_at');
    }

    public function hasUser($id) {
        $count = $this->acceptedUsers()
                        ->where('user_id', $id)
                        ->count();
        return !!$count;
    }

    public function hasUserPending($id) {
        $count = $this->belongsToMany('App\User')->where('user_id', $id)->where('accepted_by_owner', 0)->whereNull('room_user.deleted_at')->count();
        return !!$count;
    }
}
