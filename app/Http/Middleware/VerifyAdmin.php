<?php

namespace App\Http\Middleware;

use App\Models\Avatar;
use App\Models\UserInfo;
use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;

class VerifyAdmin
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
            ->value('name')=='super_admin'||UserRole::where('user_id',session('user_id'))
                ->value('name')=='admin'){
            return $next($request);
        }
        return redirect()->back();
    }
}
