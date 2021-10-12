<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;

class VerifyUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->has('user_id')) {

            return $next($request);
        }
        return redirect('/login')->with('error','Access Denied!');
    }
}
