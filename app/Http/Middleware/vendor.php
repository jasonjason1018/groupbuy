<?php

namespace App\Http\Middleware;

use Closure;

class vendor
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
        if(null !== $request->session()->get('vendorUsername')){
            return $next($request);
        }
        return redirect('/vendorLogout');
    }
}
