<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Customer;

class CheckPhoneMiddleware
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
        $phone = $request->phone;
        $check = Customer::where('phone', $phone)->count();

        if (strlen($phone) != 10 || !is_numeric($phone)) {
            return redirect()->route('client.home')->with('error', 'Sai định dạng số điện thoại, mời bạn nhập lại');
        } elseif (!auth('customers')->check()) {
            return redirect()->route('client.home')->with('error', 'Nhập số điện thoại tại đây');
        } else {
            return $next($request);
        }
    }
}
