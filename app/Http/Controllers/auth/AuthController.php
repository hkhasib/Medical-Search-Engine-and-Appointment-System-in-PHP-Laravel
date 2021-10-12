<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Avatar;
use App\Models\City;
use App\Models\Country;
use App\Models\Doctor;
use App\Models\PasswordReset;
use App\Models\State;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserInfo;
use App\Models\UserRole;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(){
        if(session()->has('user_id')||isset($_COOKIE['remember_login'])){
            return redirect(route('dashboard'));
        }
        return view('auth.login');
    }
    public function registration(){
        return view('auth.registration');
    }

    public function reset(){
        return view('auth.reset');
    }

    public function resetPassword(Request $request){
    if (PasswordReset::where('user_id','=',$request->u_id)->where('reset_key','=',$request->key)
    ->where('validity','>',date('Y-m-d H:i:s',time()))->first()==null){
    return redirect()->route('auth.reset')->with('error','No Password Request Found or the Request is Expired.');
    }
    return view('auth.reset-password')->with('user_id',$request->u_id);
    }

    public function storeResetPassword(Request $request){
        if ($request->password==null){
            return redirect()->back()->with('error','Something wrong!');
        }
        if ($request->password!=$request->conf_password){
            return redirect()->back()->with('error','Confirm Password does not match!');
        }
        User::where('id','=',$request->user_id)->update([
           'password'=>Hash::make($request->password)
        ]);

        PasswordReset::where('user_id','=',$request->user_id)->delete();

        return redirect()->route('auth.login')->with('success','Password Reset Successful. Login to Verify');
    }

    public function registrationAction(Request $request){
        if ($request->password!=$request->conf_password){
            return redirect()->back()->with('error','Confirm Password Miss matched');
        }
        if (User::where('username',$request->username)->first()===null){
            User::create([
                'username'=>strtolower($request->username),
                'password'=>Hash::make($request->password),
                'status'=>'incomplete'
            ]);
            UserRole::create([
                'user_id'=>User::where('username',$request->username)->value('id'),
                'name'=>$request->role
            ]);

            return redirect()->route('auth.login')->with('info','Login to Complete Registration!');
        }
        return redirect()->back()->with('error','Username must be unique!');

    }

    public function completeRegistration(Request $request){

        if (count(UserInfo::where('email','=',$request->email)->get())>0){
            return redirect()->back()->with('error','Another User Using this Email Address');
        }
        if (count(UserInfo::where('phone','=',$request->phone)->get())>0){
            return redirect()->back()->with('error','Phone Number is not Unique');
        }

        session()->flash('user_role',UserRole::where('user_id',session('user_id'))->value('name'));
        User::where('id',session('user_id'))->update([
           'status'=>'active'
        ]);

        UserInfo::create([
            'user_id'=>session('user_id'),
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'dob'=>$request->dob,
            'gender'=>$request->gender,
        ]);
        UserAddress::create([
            'user_id'=>session('user_id'),
            'country_id'=>$request->country,
            'state_id'=>$request->state,
            'city_id'=>$request->city,
            'zone_id'=>$request->zone,
            'area_id'=>$request->area,
            'post_code'=>$request->post_code,
            'house'=>$request->house,
        ]);
        if($request->hasFile('avatar')){
            $avatar_name=uniqid()."-".$request->file('avatar')->getClientOriginalName();
            $file_type=$request->file('avatar')->getClientOriginalExtension();
            if((strtolower($file_type)=='png'||strtolower($file_type)=='jpg')||strtolower($file_type)=='jpeg'){
                $request->file('avatar')->storeAs('avatars',session('user_id').'/'.$avatar_name);

                Avatar::create([
                    'user_id'=>session('user_id'),
                    'link'=>env('APP_URL').'/storage/avatars/'.session('user_id').'/'.$avatar_name,
                    'path'=>'/storage/avatars/'.session('user_id').'/'.$avatar_name
                ]);
            }
        }
        else{
            Avatar::create([
                'user_id'=>session('user_id'),
                'link'=>env('APP_URL')."/storage/avatars/1/admin.png",
                'path'=>"/storage/avatars/1/admin.png"
            ]);
        }
        if (session('user_role')=='doctor'){
            Doctor::create([
               'user_id'=>session('user_id'),
                'designation'=>$request->designation,
                'specialities'=>$request->specialities,
                'education'=>$request->education,
            ]);
        }
        return redirect()->route('dashboard')->with('success','User Registration Complete: '.$request->username);
    }

    public function completeUserInfo(){
        session()->flash('user_role',UserRole::where('user_id',session('user_id'))->value('name'));
        session()->flash('countries',Country::all()->sortBy('name'));
        session()->flash('states',State::all()->sortBy('name'));
        session()->flash('cities',City::all()->sortBy('name'));
        session()->flash('zones',Zone::all()->sortBy('name'));
        session()->flash('areas',Area::all()->sortBy('name'));
        return view('auth.complete-user-info');
    }

    public function verifyLogin(Request $request){
        $users = User::where('username',$request->username)->first();
        if(isset($users->username)&&($users->username!=null||$users->username!="")){
            if(strtolower($request->username)==$users->username&&Hash::check($request->password,$users->password)){
                switch ($users->status){
                    case $users->status==='active':
                        if(isset($request->remember)&&$request->remember=='checked'){
                            setcookie('remember_login',$users->id,time()+(86400 * 14), "/");
                        }
                        $request->session()->put('user_id',$users->id);
                        if (isset($_COOKIE['last_page'])){
                            return redirect($_COOKIE['last_page']);
                        }
                        return redirect('/dashboard');
                    case $users->status=='incomplete':
                        $request->session()->put('user_id',$users->id);
                        return redirect()->route('auth.user-info')->with('error','User Registration Incomplete! Complete Registration by Giving these Information!');
                    case $users->status=='inactive':
                        return redirect('login')->with('error','User account is Inactive!');
                    case $users->status=='pending':
                        return redirect('login')->with('error','User account is on Hold!');
                }

            }
            else{
                return redirect('login')->with('error','Wrong Password!');
            }
        }
        else{
            return redirect('login')->with('error','User not Found!');
        }
    }
    public function logout(){
        setcookie("remember_login", "", time() - 3600);
        session()->forget('user_id');
        return redirect('/login')->with('success','Successfully Logged Out!');
    }
}
