<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $appends = ["last_message","name","unreaded_count",'image_url'];

    public function users(){
        return $this->belongsToMany('App\User');
    }
    public function messages(){
        return $this->hasMany('App\Message');
    }
    public function house(){
        return $this->belongsTo('App\House');
    }

    public function conversationUser(){
        return $this->hasMany('App\ConversationUser');
    }

    public function getLastMessageAttribute(){
        if($message = $this->messages()->orderBy('created_at','desc')->first()){
            return $message->message;
        }
        return "";
    }

    public function getNameAttribute(){
        if($this->house()->count()){
            return $this->house->name;
        }
        return $this->users()->where('user_id','!=',\Auth::user()->id)->first()->complete_name;
    }

    public function getUnreadedCountAttribute(){
        return $this->messages()->where("to_user_id",\Auth::user()->id)->sum('unreaded');
    }

    public function getImageUrlAttribute(){
        if($this->house()->count()){
            return $this->house->preview_image_url;
        }
        return $this->users()->where('user_id','!=',\Auth::user()->id)->first()->profile_pic;
    }
}
