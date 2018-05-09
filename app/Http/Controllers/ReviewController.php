<?php

namespace App\Http\Controllers;

use App\Review;
use App\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function rateUser(Request $request) {
        Review::create([
            'title' => $request->title,
            'text' => $request->message,
            'rate' => $request->rating,
            'from_user_id' => \Illuminate\Support\Facades\Auth::user()->id,
            'to_user_id' => $request->uid,
            'lessor' => false
        ]);

        return redirect()->to('house');
    }
}
