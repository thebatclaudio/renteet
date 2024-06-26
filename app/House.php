<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class House extends Model
{
    use SoftDeletes;

    protected $appends = ['url', 'admin_url', 'latitude', 'longitude','previewReviews','beds','rating'];
    protected $hiddens = ['latitude', 'longitude'];
    

    public function owner() {
        return $this->belongsTo('App\User');
    }

    public function type() {
        return $this->belongsTo('App\HouseType');
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

    public function hasService($id) {
        return !!$this->services()->where(['services.id' => $id])->count();
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

    public function getRealLatitude() {
        return $this->getOriginal('latitude');
    }

    public function getRealLongitude() {
        return $this->getOriginal('longitude');
    }

    public function getPreviewImageUrlAttribute() {
        if($this->photos()->count()) {
            return url('/images/houses/'.$this->id.'/'.$this->photos[0]->file_name.'-670.jpg');
        }
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

    public function getRatingAttribute(){
        return $this->reviews()->groupBy('to_user_id')->avg('rate');
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

    public function minorBedPrice(){
       return $this->rooms()->orderBy('bed_price','asc')->limit(1)->pluck('bed_price')->first();
    }
}
