<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchByCoordinates(Request $request) {
        $latitude = $request->lat;
        $longitude = $request->lng;
        $searchInput = $request->searchInput;

        $mMult = cos($latitude * (pi()/180));
        $meterValue = 0.0000089831; //1 Metro espresso in gradi (equatore)

        $latOffset = 100*100 * ($meterValue * $mMult);
        $lngOffset = 100*100 * $meterValue;

        $houses = \App\House::whereBetween('latitude', [$latitude-$latOffset, $latitude+$latOffset])
                    ->whereBetween('longitude', [$longitude-$lngOffset, $longitude+$lngOffset])
                    ->get();

        return view('search')->with([
            'houses' => $houses,
            'searchInput' => $searchInput
        ]);
    }
}
