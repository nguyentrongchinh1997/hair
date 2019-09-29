<?php

namespace App\Http\Middleware;

use Closure;

class MobileEmployeeMiddleware
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
            return $next($request);
        } else {
            return redirect()->route('mobile.employee.login');
        }
        
    }
}
