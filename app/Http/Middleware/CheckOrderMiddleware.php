<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Order;

class CheckOrderMiddleware
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
        $check = Order::findOrFail($request->id);

        if ($check->status > config('config.order.status.create')) {
            return back()->with('error', 'Đơn đã check-in không được phép hủy');
        } else {
            return $next($request);
        }
    }
}
