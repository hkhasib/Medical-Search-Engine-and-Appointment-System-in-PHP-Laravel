<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function addPeople(){
        if (session('user_role')=='business'){
            session()->flash('clinics',Clinic::where('user_id',session('user_id'))->orderBy('name')->get());
        }
        elseif (session('user_role')=='admin'||session('user_role')=='super_admin'){
            session()->flash('clinics',Clinic::all()->sortBy('name'));
        }

        return view('dashboard.clinic.add-people')->with(['data_list'=>Department::join('clinics','departments.clinic_id','=','clinics.id')
            ->select('departments.name as department_name','departments.id as department_id','clinics.id as clinic_id','clinics.name as clinic_name')
            ->get()]);
    }

    public function storeEmployee(Request $request){
        if(count(User::where('username',$request->username)->get())==0){
            return redirect()->back()->with('error','No user found!');
        }
        if ($request->post_name=='front_desk'){
            if(count(Employee::where('user_id',User::where('username',strtolower($request->username))->value('id'))
                    ->where('employment_status','=','active')->get())>0){
                return redirect()->back()->with('error','This FrontDesk User is Actively Employed in Another Clinic');
            }
        }
        Employee::create([
           'user_id'=>User::where('username',strtolower($request->username))->value('id'),
            'post_name'=>strtolower($request->post_name),
            'clinic_id'=>$request->clinic_id,
            'department_id'=>$request->department_id,
            'employment_status'=>$request->employment_status
        ]);
        return redirect()->back()->with('success','The following user has been successfully added: '.$request->username);
    }

    public function employeeList(Request $request){
        if (session('user_role')=='business') {
            session()->flash('clinics', Clinic::where('user_id', session('user_id'))->orderBy('name')->get());
            return view('dashboard.clinic.view-employees')->with(['data_list'=>UserAddress::join('users','user_addresses.user_id','=','users.id')
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
                ->where('clinics.id','=',$request->clinic_id)
                ->get(['user_addresses.*','users.id as user_id','users.username as username',
                    'user_infos.*','avatars.*','user_roles.name as role','countries.name as country',
                    'states.name as state','cities.name as city','zones.name as zone',
                    'areas.name as area','employees.id as employee_id'])]);
        }
        else{
            session()->flash('clinics',Clinic::all()->sortBy('name'));
            return view('dashboard.clinic.view-employees')->with(['data_list'=>UserAddress::join('users','user_addresses.user_id','=','users.id')
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
                ->where('clinics.id','=',$request->clinic_id)
                ->get(['user_addresses.*','users.id as user_id','users.username as username',
                    'user_infos.*','avatars.*','user_roles.name as role','countries.name as country',
                    'states.name as state','cities.name as city','zones.name as zone',
                    'areas.name as area','employees.id as employee_id'])]);
        }
    }

    public function editEmployee($employee_id){
        return view('dashboard.clinic.edit-employee')->with('data',Employee::join('clinics','employees.clinic_id','=','clinics.id')
            ->join('user_infos','employees.user_id','=','user_infos.user_id')
            ->where('employees.id','=',$employee_id)
            ->get(['employees.id as employee_id','clinics.*','user_infos.*','employees.*']));
    }

    public function storeEditEmployee(Request $request){
        Employee::where('id',$request->employee_id)->update([
           'post_name'=>$request->post_name,
           'employment_status'=>$request->employment_status
        ]);

        return redirect()->back()->with('success')->with('success','Employee data updated!');
    }
}
