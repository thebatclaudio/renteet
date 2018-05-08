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
        'profile_url', 'profile_pic', 'profile_pic_real_size', 'profile_complete', 'lessor'
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

    public function hasHouse() {
        return RoomUser::where('user_id', $this->id)->first()->exists;
    }
    
    public function houses() {
        return $this->hasMany('App\House', 'owner_id');
    }

    public function rooms() {
        return $this->belongsToMany('App\Room')->withPivot('accepted_by_owner', 'interested');
    }

    public function interests() {
        return $this->belongsToMany('App\Interest', 'users_interests');
    }
}
