<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Membership;

class CheckMembershipMiddleware
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
        $customer_id = $request->customer_id;
        $card_id = $request->card_id;
        $membership = Membership::where('customer_id', $customer_id)
                                    ->where('card_id', $card_id)
                                    ->first();

        if (isset($membership) && $membership->status == 1) {
            return redirect()->route('membership.list')->with('error', 'Thành viên đã mua thẻ này');
        } else {
            return $next($request);
        }
        
    }
}
