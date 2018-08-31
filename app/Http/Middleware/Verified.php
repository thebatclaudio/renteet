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

            if(!$user->verified && $user->created_at->lt(\Carbon\Carbon::now()->subDays(3))) {
                \Log::info('quia');
                return redirect('/login')->with('unverified', true);
            }
        }

        return $next($request);
    }
}
