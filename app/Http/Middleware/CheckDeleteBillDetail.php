<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\BillDetail;

class CheckDeleteBillDetail
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
        $billDetail = BillDetail::findOrFail($request->billDetailId);
        $billId = $billDetail->bill_id;
        $checkBillDetail = BillDetail::where('bill_id', $billId)->count();

        if ($checkBillDetail > 1) {
            return $next($request);
        } 
        
    }
}
