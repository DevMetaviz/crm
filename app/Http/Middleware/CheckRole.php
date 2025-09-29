<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckRole 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $right_id)
    {

        
            // if (Auth::guard($guard)->check()) {
            //     return redirect(RouteServiceProvider::HOME);
            // }
         
            if (! Auth::user()->have_sub_role($right_id)) {
                    return redirect('dashboard');
                }
            


            // else
            // {
            //     return route('login');
            // }
        //print_r('y');die;
        
        return $next($request);
    }
}
