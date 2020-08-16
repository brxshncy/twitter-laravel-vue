<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class TwitterUser
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
        if(!Auth::guard('twitterUser')->check()){
            return redirect('/')->with('red','You need to login first');
        }
        return $next($request);
    }
}
