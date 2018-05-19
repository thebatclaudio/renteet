<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseType extends Model
{
    protected $table = "house_types";

    protected $fillable = ['name'];
}
