<?php

namespace App\Http\Middleware;

use Closure;

class LoginMobileMiddleware
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
            return redirect()->route('mobile.home');
        } else {
            return $next($request);
        }
    }
}
