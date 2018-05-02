<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [ 'title', 'text', 'rate', 'from_user_id', 'to_user_id', 'lessor' ];
}
