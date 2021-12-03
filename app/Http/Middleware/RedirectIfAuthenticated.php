<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $role = Auth::user()->role; 
               /* if($role == '1' || $role == 1)
                {
                    return '/admin';
                }
                else{
                    return '/home';
                }*/
                switch ($role) {
                    case '1':
                        return redirect('/admin');
                        break;
                    case '0':
                        return redirect('/home');
                        break; 
    
                    default:
                        return redirect('/'); 
                        break;
                }
                
            }
        }

        return $next($request);
    }
}