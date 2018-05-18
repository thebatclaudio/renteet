<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userCity = \Auth::user()->livingCity;
        $houses = SearchController::getHousesByLatLng($userCity->latitude, $userCity->longitude);
        
        return view('home', [
            'houses' => $houses
        ]);
    }

    public function dashboard() {
        return view('admin.dashboard')->withUser(\Auth::user());
    }
}
