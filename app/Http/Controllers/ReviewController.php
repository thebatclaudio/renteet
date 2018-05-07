<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function rateUser(Request $request) {
        Review::create([
            'title' => $request->title,
            'text' => $request->text,
            'rate' => $request->rate,
            'from_user_id' => \Illuminate\Support\Facades\Auth::user()->id,
            'to_user_id' => $request->uid,
            'lessor' => false
        ]);

        return view('house')->with('status', 'Hai recensito con successo '.App\User::find($request->uid)->first_name.' '.App\User::find($request->uid)->second_name);
    }
}
