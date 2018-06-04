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
        if(geoip()->getLocation()->lat && geoip()->getLocation()->lon) {
            $houses = SearchController::getHousesByLatLng(geoip()->getLocation()->lat, geoip()->getLocation()->lon);
            $locationName = geoip()->getLocation()->city;
        } else {
            $houses = SearchController::getHousesByLatLng($userCity->latitude, $userCity->longitude);
            $locationName = $userCity->livingCity->name;
        }

        return view('home', [
            'houses' => $houses,
            'locationName' => $locationName
        ]);
    }

    public function dashboard() {
        return view('admin.dashboard', [
            'user' => \Auth::user(),
            'houses' => \Auth::user()->houses()->orderBy('last_step', 'ASC')->orderBy('updated_at', 'DESC')->get()
        ]);
    }
}
