<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $appends = ['url', 'admin_url', 'latitude', 'longitude','previewReviews'];
    protected $hiddens = ['latitude', 'longitude'];
    

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

    public function getLatitudeAttribute($value){

        $mMult = cos($value * (pi()/180));
        $meterValue = 0.0000089831; //1 Metro espresso in gradi (equatore)

        $latOffset = rand(1,100) * ($meterValue * $mMult);
        if(rand(0,1)){
            return $value - $latOffset;
        }else{
            return $value + $latOffset;
        }
    }

    public function getLongitudeAttribute($value){

        $meterValue = 0.0000089831; //1 Metro espresso in gradi (equatore)
        $lngOffset = rand(1,50) * $meterValue;

        if(rand(0,1)){
            return $value - $lngOffset;
        }else{
            return $value + $lngOffset;
        }
    }

    public function getPreviewImageUrlAttribute() {
        return route('house.thumbnail',$this->id);
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

    public function getAdminUrlAttribute() {
        return \URL::to('/admin/house/'.$this->id);
    }

    public function scopeWithRoomsUsersCount($query) {
        return $query->whereHas('rooms', function($query){
            return $query->withCount(['users'=>function($query){
                return $query->where('start', '<=', \Carbon\Carbon::now()->format('Y-m-d'))
                    ->where('stop','>=',\Carbon\Carbon::now()->format('Y-m-d'));
            }]);
        });
    }

    private function reviews(){
        return \App\Review::whereHas('roomUser',function($query){
            return $query->whereHas('room',function($query){
                return $query->whereIn('id',$this->rooms->pluck('id'));
            });
        })->where('lessor',true);
    }

    public function getPreviewReviewsAttribute(){
        return $this->reviews()->orderBy('created_at')->limit(9)->get();
    }

    public function relatedUsers(){
        $users = [];
        foreach($this->rooms as $room){
            foreach($room->acceptedUsers as $user){
                $users[] = $user->id;
            }
        }
        $users[] = $this->owner->id;
        return $users;
    }

}
