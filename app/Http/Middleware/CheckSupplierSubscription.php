<?php

namespace App\Http\Middleware;

use Closure;

class CheckSupplierSubscription
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

        if($request->user()->free_user == 0){
            if (!$request->user()->onGenericTrial()) {
                if ($request->user() && ! $request->user()->subscribed('Supplier Monthly Plan - SmokeDrop')) {
                    return redirect('settings');
                }
            }
        }

        return $next($request);
    }
}
