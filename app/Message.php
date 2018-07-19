<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $fillable = [
        'from_user_id', 'to_user_id', 'message','conversation_id','unreaded'
    ];

    /**
     * A message belong to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromUser()
    {
    return $this->belongsTo("\App\User","from_user_id");
    }

    public function toUser()
    {
    return $this->belongsTo("\App\User","to_user_id");
    }
}
