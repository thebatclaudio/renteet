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

    public function newHouseWizardStepOne(){
        return view('admin.wizard.one', [
            'houseTypes' => \App\HouseType::all()
        ]);
    }

    public function newHouseWizardStepTwo(){
        return view('admin.wizard.two');
    }

    public function newHouseWizardStepThree(){
        return view('admin.wizard.three');
    }

    public function newHouseWizardStepFour(){
        return view('admin.wizard.four');
    }
}
