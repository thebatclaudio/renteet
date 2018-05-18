<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function house($id) {
        if($house = \App\House::find($id)) {
            if($house->owner->id === \Auth::user()->id) {
                return view('admin.house')->withHouse($house);
            }
        }
    }

    public function showNewHouseForm() {
        return view('admin.newHouse');
    }
}
