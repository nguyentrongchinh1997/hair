<?php

namespace App\Http\Middleware;

use Closure;

class LoginMobileEmployeeMiddleware
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
        if (auth('employees')->check()) {
            return redirect()->route('mobile.employee.home');
        } else {
            return $next($request);
        }
    }
}
