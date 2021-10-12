<?php

namespace App\Http\Middleware;

use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;

class VerifyClinicDataAccess
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
        if((UserRole::where('user_id',session('user_id'))
                    ->value('name')=='business'||UserRole::where('user_id',session('user_id'))
                    ->value('name')=='admin')||(UserRole::where('user_id',session('user_id'))
                ->value('name')=='super_admin'||UserRole::where('user_id',session('user_id'))
                    ->value('name')=='doctor')||(UserRole::where('user_id',session('user_id'))
                    ->value('name')=='front-desk'||UserRole::where('user_id',session('user_id'))
                    ->value('name')=='patient')){
            return $next($request);
        }
        return redirect()->back();
    }
}
