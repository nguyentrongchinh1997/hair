<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Membership;

class CheckExpiryMembership
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
        $membership = Membership::findOrFail($request->id);

        if ($membership->status == 0) {
            return $next($request);
        } else {
            return redirect()->route('membership.list')->with('error', 'Thẻ của thành viên này chưa hết hạn, bạn không được phép xóa');
        }
        
    }
}
