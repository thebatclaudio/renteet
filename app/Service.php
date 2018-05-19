<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = "services";

    protected $fillable = ['name', 'icon_class', 'quantity_needed'];

    public function scopeQuantityNeeded($query, $boolean) {
        return $query->where('quantity_needed', $boolean);
    }
}
