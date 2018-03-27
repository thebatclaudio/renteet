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
        if(!\Auth::user()->profile_complete) {
            return redirect()->to('/complete-signup/upload-picture');
        } else {
            return view('home');
        }
    }

    public function dashboard() {
        return view('admin.dashboard')->withUser(\Auth::user());
    }
}
