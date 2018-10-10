<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchByCoordinates(Request $request) {
        $latitude = $request->lat;
        $longitude = $request->lng;

        $radius = (isset($request->radius)) ? $request->radius : 100*100;

        $houses = $this->getHousesByLatLng($latitude, $longitude, $radius);

        if($request->view == "list") {
            return view('searchList')->with([
                'houses' => $houses,
                'searchInput' => $request->searchInput,
                'radius' => $radius
            ]);
        }

        return view('search')->with([
            'houses' => $houses,
            'searchInput' => $request->searchInput,
            'radius' => $radius
        ]);
    }

    public static function getHousesByLatLng($latitude, $longitude, $radius) {
        $mMult = cos($latitude * (pi()/180));
        $meterValue = 0.0000089831; //1 Metro espresso in gradi (equatore)

        $latOffset = $radius * ($meterValue * $mMult);
        $lngOffset = $radius * $meterValue;

        return \App\House::whereBetween('latitude', [$latitude-$latOffset, $latitude+$latOffset])
                    ->whereBetween('longitude', [$longitude-$lngOffset, $longitude+$lngOffset])
                    ->where('last_step', 4)
                    ->inRandomOrder()
                    ->get()
                    ->filter(function($house){
                        foreach($house->rooms as $room){
                            if($room->beds - $room->acceptedUsers()->count() >= 1){
                                return true;
                            }
                        }
                        return false;
                    });
    }
}
