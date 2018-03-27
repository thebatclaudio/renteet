<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadPictureController extends Controller
{
    /**
     * Show upload picture formtail
     * @return view
     */
    public function showUploadPictureForm() {
        return view("profile.uploadPicture");
    }

    /**
     * @return view
     */
    public function uploadPicture(Request $request) {        
        
        request()->validate([

            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        request()->profile_picture->move(public_path('images/profile_pics'), \Auth::user()->id.".jpg");

        return redirect('/complete-signup/crop-picture');
    
    }

    public function showCropPicture() {
        return view("profile.cropPicture");
    }

    public function cropPicture(Request $request) {
        $path = public_path('images/profile_pics')."/".\Auth::user()->id."-cropped.jpg";

        \Image::make(file_get_contents($request->blob))->save($path);

        return redirect('/home');

    }
    
}
