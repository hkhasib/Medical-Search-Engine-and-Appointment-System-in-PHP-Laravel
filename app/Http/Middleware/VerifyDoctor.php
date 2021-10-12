<?php

namespace App\Http\Middleware;

use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;

class VerifyDoctor
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
        if(UserRole::where('user_id',session('user_id'))
                ->value('name')=='doctor'){
            return $next($request);
        }
        return redirect()->back();
    }
}
