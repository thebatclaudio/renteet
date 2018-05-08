<?php

namespace App\Http\Middleware;

use Closure;

class ProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(\Auth::check()){
            $user = \Auth::user();

            // controllo se c'è l'immagine del profilo
            if(!file_exists( public_path() . '/images/profile_pics/' . $user->id . '.jpg')) {
                return redirect('/complete-signup/upload-picture/');
            }

            // se c'è l'immagine del profilo, controllo se è stata già croppata
            if(!file_exists( public_path() . '/images/profile_pics/' . $user->id . '-cropped.jpg')) {
                return redirect('/complete-signup/crop-picture/');
            }

            // controllo se sono stati inseriti i dati personali
            if(empty($user->born_city) OR empty($user->living_city) OR empty($user->gender)) {
                return redirect('/complete-signup/personal-info/');
            }
        }

        return $next($request);
    }
}
