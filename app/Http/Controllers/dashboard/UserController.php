<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Avatar;
use App\Models\City;
use App\Models\Country;
use App\Models\Doctor;
use App\Models\State;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserInfo;
use App\Models\UserRole;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Comment\Doc;

class UserController extends Controller
{
    public function index(){
        if (session('user_role')=='business'){
            return view('dashboard.users.index')->with(['data_list'=>UserAddress::join('users','user_addresses.user_id','=','users.id')
                ->join('user_infos','users.id','=','user_infos.user_id')
                ->join('user_roles','user_infos.user_id','=','user_roles.user_id')
                ->join('avatars','user_roles.user_id','=','avatars.user_id')
                ->join('countries','user_addresses.country_id','=','countries.id')
                ->join('states','user_addresses.state_id','=','states.id')
                ->join('cities','user_addresses.city_id','=','cities.id')
                ->join('zones','user_addresses.zone_id','=','zones.id')
                ->join('areas','user_addresses.area_id','=','areas.id')
                ->join('employees','users.id','=','employees.user_id')
                ->join('clinics','employees.clinic_id','=','clinics.id')
                ->where('clinics.user_id','=',session('user_id'))
                ->get(['user_addresses.*','users.id as user_id','users.username as username',
                    'user_infos.*','avatars.*','user_roles.name as role','countries.name as country',
                    'states.name as state','cities.name as city','zones.name as zone',
                    'areas.name as area'])]);
        }
        else{
            return view('dashboard.users.index')->with(['data_list'=>UserAddress::join('users','user_addresses.user_id','=','users.id')
                ->join('user_infos','users.id','=','user_infos.user_id')
                ->join('user_roles','user_infos.user_id','=','user_roles.user_id')
                ->join('avatars','user_roles.user_id','=','avatars.user_id')
                ->join('countries','user_addresses.country_id','=','countries.id')
                ->join('states','user_addresses.state_id','=','states.id')
                ->join('cities','user_addresses.city_id','=','cities.id')
                ->join('zones','user_addresses.zone_id','=','zones.id')
                ->join('areas','user_addresses.area_id','=','areas.id')
                ->get(['user_addresses.*','users.id as user_id','users.username as username',
                    'user_infos.*','avatars.*','user_roles.name as role','countries.name as country',
                    'states.name as state','cities.name as city','zones.name as zone',
                    'areas.name as area'])]);
        }
    }
    public function userAuthList(){
        return view('dashboard.users.authorizations')->with(['data_list'=>UserAddress::join('users','user_addresses.user_id','=','users.id')
            ->join('user_infos','users.id','=','user_infos.user_id')
            ->join('user_roles','user_infos.user_id','=','user_roles.user_id')
            ->join('avatars','user_roles.user_id','=','avatars.user_id')
            ->get(['user_addresses.*','users.id as user_id','users.username as username','users.status as status',
                'user_infos.*','avatars.*','user_roles.name as role'])]);
    }
    public function storeUserAuthorization($user_id, Request $request){
        if (session('user_role')=='super_admin'||$request->role!='admin'){
            User::where('id',$user_id)->update([
                'status'=>$request->status
            ]);
            return redirect()->back()->with('success','Status updated for the following user: '.$request->username);
        }
        return redirect()->back()->with('error','Status cannot be updated for this user: '.$request->username);

    }
    public function userProfile(){

    }
    public function addUser(){
        session()->flash('countries',Country::all()->sortBy('name'));
        session()->flash('states',State::all()->sortBy('name'));
        session()->flash('cities',City::all()->sortBy('name'));
        session()->flash('zones',Zone::all()->sortBy('name'));
        session()->flash('areas',Area::all()->sortBy('name'));
        return view('dashboard.users.add-user');
    }
    public function storeUser(Request $request){
        User::create([
            'username'=>strtolower($request->username),
            'password'=>Hash::make($request->password),
            'status'=>$request->status,
        ]);
        $users = User::where('username',$request->username)->first();
        UserInfo::create([
            'user_id'=>$users->id,
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'dob'=>$request->dob,
            'gender'=>$request->gender,
        ]);
        UserRole::create([
            'user_id'=>$users->id,
            'name'=>$request->role,
        ]);
        UserAddress::create([
            'user_id'=>$users->id,
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
                $request->file('avatar')->storeAs('avatars',$users->id.'/'.$avatar_name);

                Avatar::create([
                    'user_id'=>$users->id,
                    'link'=>env('APP_URL').'/storage/avatars/'.$users->id.'/'.$avatar_name,
                    'path'=>'/storage/avatars/'.$users->id.'/'.$avatar_name
                ]);
            }
        }
        else{
            Avatar::create([
                'user_id'=>$users->id,
                'link'=>env('APP_URL')."/storage/avatars/1/admin.png",
                'path'=>"/storage/avatars/1/admin.png"
            ]);
        }
        if(isset($request->designation)){
            Doctor::create([
            'user_id'=>$users->id,
                'designation'=>$request->designation,
                'specialities'=>$request->specialities,
                'education'=>$request->education,
            ]);
        }
        return redirect()->back()->with('success','Successfully Added the User: '.$request->username);
    }

    public function editUserView($id){
        if (User::where('id','=',$id)->first()==null){
            return redirect()->back()->with('error','user not found!');
        }
        $addresses=UserAddress::where('user_id',$id)->first();
        session()->flash('countries',Country::where('id','!=',$addresses->country_id)->get()->sortBy('name'));
        session()->flash('states',State::where('id','!=',$addresses->state_id)->get()->sortBy('name'));
        session()->flash('cities',City::where('id','!=',$addresses->city_id)->get()->sortBy('name'));
        session()->flash('zones',Zone::where('id','!=',$addresses->zone_id)->get()->sortBy('name'));
        session()->flash('areas',Area::where('id','!=',$addresses->area_id)->get()->sortBy('name'));
        return view('dashboard.users.edit-user')->with(['data'=>UserAddress::join('users','user_addresses.user_id','=','users.id')
            ->join('user_infos','users.id','=','user_infos.user_id')
            ->join('user_roles','user_infos.user_id','=','user_roles.user_id')
            ->join('avatars','user_roles.user_id','=','avatars.user_id')
            ->where('users.id','=',$id)
            ->join('countries','user_addresses.country_id','=','countries.id')
            ->join('states','user_addresses.state_id','=','states.id')
            ->join('cities','user_addresses.city_id','=','cities.id')
            ->join('zones','user_addresses.zone_id','=','zones.id')
            ->join('areas','user_addresses.area_id','=','areas.id')
            ->get(['user_addresses.*','users.*',
                'user_infos.*','avatars.*','user_roles.name as user_type',
                'countries.name as country','states.name as state','cities.name as city',
                'zones.name as zone','areas.name as area'])]);
    }

    public function editUserSelf(){
        if (User::where('id','=',session('user_id'))->first()==null){
            return redirect()->back()->with('error','user not found!');
        }
        $addresses=UserAddress::where('user_id',session('user_id'))->first();
        session()->flash('countries',Country::where('id','!=',$addresses->country_id)->get()->sortBy('name'));
        session()->flash('states',State::where('id','!=',$addresses->state_id)->get()->sortBy('name'));
        session()->flash('cities',City::where('id','!=',$addresses->city_id)->get()->sortBy('name'));
        session()->flash('zones',Zone::where('id','!=',$addresses->zone_id)->get()->sortBy('name'));
        session()->flash('areas',Area::where('id','!=',$addresses->area_id)->get()->sortBy('name'));
        if (session('user_role')=='doctor'){
            return view('dashboard.settings.edit-profile')->with(['data'=>UserAddress::join('users','user_addresses.user_id','=','users.id')
                ->join('user_infos','users.id','=','user_infos.user_id')
                ->join('user_roles','user_infos.user_id','=','user_roles.user_id')
                ->join('avatars','user_roles.user_id','=','avatars.user_id')
                ->join('doctors','user_infos.user_id','=','doctors.user_id')
                ->where('users.id','=',session('user_id'))
                ->join('countries','user_addresses.country_id','=','countries.id')
                ->join('states','user_addresses.state_id','=','states.id')
                ->join('cities','user_addresses.city_id','=','cities.id')
                ->join('zones','user_addresses.zone_id','=','zones.id')
                ->join('areas','user_addresses.area_id','=','areas.id')
                ->get(['user_addresses.*','users.*',
                    'user_infos.*','avatars.*','user_roles.name as user_type',
                    'countries.name as country','states.name as state','cities.name as city',
                    'zones.name as zone','areas.name as area','doctors.designation','doctors.education'
                    ,'doctors.specialities'])]);
        }
        return view('dashboard.settings.edit-profile')->with(['data'=>UserAddress::join('users','user_addresses.user_id','=','users.id')
            ->join('user_infos','users.id','=','user_infos.user_id')
            ->join('user_roles','user_infos.user_id','=','user_roles.user_id')
            ->join('avatars','user_roles.user_id','=','avatars.user_id')
            ->where('users.id','=',session('user_id'))
            ->join('countries','user_addresses.country_id','=','countries.id')
            ->join('states','user_addresses.state_id','=','states.id')
            ->join('cities','user_addresses.city_id','=','cities.id')
            ->join('zones','user_addresses.zone_id','=','zones.id')
            ->join('areas','user_addresses.area_id','=','areas.id')
            ->get(['user_addresses.*','users.*',
                'user_infos.*','avatars.*','user_roles.name as user_type',
                'countries.name as country','states.name as state','cities.name as city',
                'zones.name as zone','areas.name as area'])]);
    }

    public function passwordChanger(){
        return view('dashboard.settings.change-password');
    }

    public function storePasswordChange(Request $request){
if (Hash::check($request->current_password,User::where('id',session('user_id'))->first()->password)){
    User::where('id',session('user_id'))->update([
       'password'=>Hash::make($request->new_password)
    ]);
    return redirect()->back()->with('success','Password Updated');
}
else{
    return redirect()->back()->with('error','Wrong Password');
}
    }

    public function editUser(Request $request){
        User::where('id','=',$request->id)->update([
            'username'=>strtolower($request->username)
        ]);
        UserInfo::where('user_id','=',$request->id)->update([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'dob'=>$request->dob,
            'gender'=>$request->gender,
        ]);
        UserRole::where('user_id','=',$request->id)->update([
            'name'=>$request->role
        ]);
        UserAddress::where('user_id','=',$request->id)->update([
            'country_id'=>$request->country,
            'state_id'=>$request->state,
            'city_id'=>$request->city,
            'zone_id'=>$request->zone,
            'area_id'=>$request->area,
            'post_code'=>$request->post_code,
            'house'=>$request->house,
        ]);
        if (isset($request->avatar)){
            $avatar_name=uniqid()."-".$request->file('avatar')->getClientOriginalName();
            $file_type=$request->file('avatar')->getClientOriginalExtension();
            if((strtolower($file_type)=='png'||strtolower($file_type)=='jpg')||strtolower($file_type)=='jpeg'){
                $request->file('avatar')->storeAs('avatars',$request->id.'/'.$avatar_name);

                Avatar::where('user_id','=',$request->id)->update([
                    'user_id'=>$request->id,
                    'link'=>env('APP_URL').'/storage/avatars/'.$request->id.'/'.$avatar_name,
                    'path'=>'/storage/avatars/'.$request->id.'/'.$avatar_name
                ]);
                if ($request->current_avatar_path!="/storage/avatars/1/admin.png"){
                    if (file_exists(public_path().$request->current_avatar_path)){
                        unlink(public_path().$request->current_avatar_path);
                    }
                }
            }
        }

        if (isset($request->designation)){
            Doctor::where('user_id',$request->id)->update([
               'designation'=>$request->designation,
                'specialities'=>$request->specialities,
                'education'=>$request->education,
            ]);
        }
        return redirect()->back()->with('success','successfully changed');
    }
    public function deleteUser(Request $request){
        if (session('user_id')==$request->id){
            return redirect()->back()->with('error','You cannot delete yourself!');
        }
        else{
            if ($request->user_type=='doctor'){
                Doctor::where('user_id',$request->id)->delete();
            }
            UserAddress::where('user_id',$request->id)->delete();
            Avatar::where('user_id',$request->id)->delete();
            UserInfo::where('user_id',$request->id)->delete();
            UserRole::where('user_id',$request->id)->delete();
            User::where('id',$request->id)->delete();
            if ($request->current_avatar_path!="/storage/avatars/1/admin.png"){
                if (file_exists(public_path().$request->current_avatar_path)){
                    unlink(public_path().$request->current_avatar_path);
                }
            }
            return redirect()->route('user.view')->with('success','Successfully deleted the user: '.$request->username);
        }

    }
}
