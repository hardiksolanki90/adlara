<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next, $guard = 'admins')
     {
         if (Auth::guard($guard)->check()) {
             return redirect('/authority/dashboard');
         }

         return $next($request);
     }
}
