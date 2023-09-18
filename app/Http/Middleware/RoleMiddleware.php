<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //Check if user is authenticated
        if(Auth::check()){
            //Check if user is ADMIN (1)
            if(Auth::user()->role == 1){
                return $next($request);
            }
            //if user is NOT ADMIN (0)
            else{
                return redirect('/login')->with('message', 'User Unauthorized !');
            }
        }else{
            return redirect('/login')->with('message', 'User Unauthenticated !');
        }

        return $next($request);
    }
}
