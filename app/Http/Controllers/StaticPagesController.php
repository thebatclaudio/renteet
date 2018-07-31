<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    public function showHowItWorks(){
        return view('static.howItWorks');
    }

    public function showHowItWorksForLessors(){
        return view('static.howItWorksForLessors');
    }
}
