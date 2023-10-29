<?php

namespace App\Http\Middleware;

use Closure;

class adminauth
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
        if(null !== $request->session()->get('user_data')){
            return $next($request);
        }
        return redirect('/admin/logout');
    }
}
