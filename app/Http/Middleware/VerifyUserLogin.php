<?php

namespace App\Http\Middleware;

use App\Models\Avatar;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;

class VerifyUserLogin
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
        if(session()->has('user_id')||isset($_COOKIE['remember_login'])){
            if (isset($_COOKIE['remember_login'])){
                $request->session()->put('user_id',$_COOKIE['remember_login']);
            }
            $profile=UserInfo::where('user_id',session('user_id'))
                ->first();
            switch (User::where('id',session('user_id'))->value('status')){
                case 'active':
                    session()->flash('user_role',UserRole::where('user_id',session('user_id'))->value('name'));
                    session()->flash('avatar_url',Avatar::where('user_id',session('user_id'))->value('path'));
                    session()->flash('profile_name',$profile->first_name." ".$profile->last_name);
                    return $next($request);
                case 'incomplete':
                    return redirect()->route('auth.user-info');
                case 'inactive':
                    return redirect('/login')->with('error','Your account has been inactive or restricted');
                default:
                    return redirect('/');
            }
        }
        return redirect('/login')->with('error','Access Denied!');
    }
}
