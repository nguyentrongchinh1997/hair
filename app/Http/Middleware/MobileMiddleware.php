<?php

namespace App\Http\Middleware;

use Closure;

class MobileMiddleware
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
        if (auth('customers')->check()) {
            return $next($request);
        } else {
            return redirect()->route('mobile.login');
        }
        
    }
}
