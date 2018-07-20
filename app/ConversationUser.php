<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConversationUser extends Model
{
    protected $table = 'conversation_user';
    protected $fillable = ['user_id','conversation_id'];

    public function conversation(){
        return $this->belongTo('App\Conversation');
    }
}
