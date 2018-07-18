<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Message;
use App\House;

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
        return $this->belongsToMany('App\Room')->withPivot('accepted_by_owner', 'interested', 'start', 'stop', 'created_at', 'updated_at', 'available_from');
    }

    public function livingRooms() {
        return $this->rooms()->where('accepted_by_owner', true)
            ->where(function($query){
                $query->where('stop','>=',\Carbon\Carbon::now()->format('Y-m-d'))
                ->orWhereNull('stop');
            });
    }

    public function relatedHouses(){
        return House::where(function($query){
            return $query->whereIn('id',$this->houses->pluck('id'))
            ->orWhereIn('id',$this->livingRooms->pluck('house_id'));
        })->get();
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

    public function receivedMessages(){
        return Message::where(function($query){
            $query->where('to_user_id',$this->id)->orWhere(function($query){
                return $query->whereIn('to_house_id',$this->houses->pluck('id'))
                ->orWhereIn('to_house_id',$this->livingRooms->pluck('house_id'));
            });
        });
    }

    public function houseConversations(){
        return $this->receivedMessages()->whereNotNull('to_house_id')->join('houses', 'messages.to_house_id', '=', 'houses.id')->groupBy('to_house_id')->select(\DB::raw("MAX(messages.id) as id"),\DB::raw("'house' as type"),\DB::raw('MAX(messages.created_at) as created_at'),\DB::raw('SUM(unreaded) as unreaded'),\DB::raw('houses.name as name'))->get();
    }

    public function userConversations(){
        return $this->receivedMessages()->whereNull('to_house_id')->join('users', 'messages.from_user_id', '=', 'users.id')->groupBy('from_user_id')->select(\DB::raw("MAX(messages.id) as id"),\DB::raw("'user' as type"),\DB::raw('MAX(messages.created_at) as created_at'),\DB::raw('SUM(unreaded) as unreaded'),\DB::raw("CONCAT(users.first_name,' ',users.last_name) as name"))->get();
    }

    public function conversations(){
        return $this->userConversations()->merge($this->houseConversations())->all();
    }
}
