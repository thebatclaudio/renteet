<?php

namespace App\Http\Middleware;

use Closure;

class Verified
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

            if(!$user->verified){
                if(isset($user->verifyUser)){
                    if($user->verifyUser->updated_at->lt(\Carbon\Carbon::now()->subDays(3))) {
                        return redirect('/login')->with('unverified', true);
                    }
                }else{
                    return redirect('/login')->with('error', true);
                }
            }
        }

        return $next($request);
    }
}
