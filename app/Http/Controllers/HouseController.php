<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\House;

class HouseController extends Controller
{
    public function getThumbnail($id){
        if($house = House::find($id)){
            if($house->photos->count()){
                $fileName = $house->photos->first()->file_name;
                return \Image::make(public_path('images/houses/'.$house->id.'/'.$fileName.'-490.jpg'))->response();
            } else {
                // TODO: creare immagine placeholder
                return \Image::canvas(300,300,'#212121')->response();
            }
        }else{
            return \Image::canvas(300,300,'#212121')->response();
        }
    }
}
