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

    public function showAdvantages(){
        return view('static.advantages');
    }

    public function showAdvantagesForLessors(){
        return view('static.advantagesForLessors');
    }

    public function showTermsAndConditions(){
        return view('static.termsAndConditions');
    }

    public function showPrivacyPolicy(){
        return view('static.privacyPolicy');
    }

    public function showCookiePolicy(){
        return view('static.cookiePolicy');
    }

    public function showFAQ(){
        return view('static.faq');
    }
}
