<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'birthday', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'profile_url', 'profile_pic', 'profile_pic_real_size', 'profile_complete', 'lessor', 'age', 'rating', 'complete_name'
    ];

    public function getProfileUrlAttribute() {
        return "/profile/".$this->id;
    }

    public function getLessorAttribute() {
        return $this->houses()->count() > 0;
    }

    public function getProfilePicAttribute() {
        if(file_exists( public_path() . '/images/profile_pics/' . $this->id . '-cropped.jpg')) {
            return "/images/profile_pics/".$this->id."-cropped.jpg?".rand();
        } else {
            return "/images/default-user.png";
        }
    }

    public function getProfilePicRealSizeAttribute() {
        if(file_exists( public_path() . '/images/profile_pics/' . $this->id . '.jpg')) {
            return "/images/profile_pics/".$this->id.".jpg?".rand();
        } else {
            return "/images/default-user.png";
        }
    }

    public function getProfileCompleteAttribute() {
        //check if profile is completed
        if(!file_exists( public_path() . '/images/profile_pics/' . $this->id . '-cropped.jpg')) {
            return false;
        }
        return true;
    }

    public function getAgeAttribute() {
        return \Carbon\Carbon::now()->format('Y')-\Carbon\Carbon::createFromFormat('Y-m-d', $this->birthday)->format('Y');
    }

    public function getCompleteNameAttribute() {
        return $this->first_name." ".$this->last_name;
    }

    public function isLessor() {
        return !!$this->houses()->count();
    }

    public function isTenant() {
        return !!$this->livingRooms()->count();
    }
    
    public function houses() {
        return $this->hasMany('App\House', 'owner_id');
    }

    public function rooms() {
        return $this->belongsToMany('App\Room')->withPivot('accepted_by_owner', 'interested', 'start', 'stop', 'created_at', 'updated_at');
    }

    public function livingRooms() {
        return $this->rooms()->where('accepted_by_owner', true)->where('start','<=',\Carbon\Carbon::now()->format('Y-m-d'))->where('stop',NULL);
    }

    public function pendingRequests() {
        return $this->rooms()->where('accepted_by_owner', false);
    }

    public function interests() {
        return $this->belongsToMany('App\Interest', 'users_interests');
    }

    public function languages() {
        return $this->belongsToMany('App\Language', 'languages_users');
    }

    public function bornCity() {
        return $this->belongsTo('App\City', 'born_city_id');
    }

    public function livingCity() {
        return $this->belongsTo('App\City', 'living_city_id');
    }
    
    public function reviews() {
        return $this->hasMany('App\Review', 'to_user_id');
    }

    public function getRatingAttribute() {
        return $this->reviews()->avg('rate');
    }
}
