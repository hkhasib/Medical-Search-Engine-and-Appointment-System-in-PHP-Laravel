<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Clinic;
use App\Models\ClinicAddress;
use App\Models\Country;
use App\Models\Department;
use App\Models\Logo;
use App\Models\State;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function index(){
        if (session('user_role')=='business'){
            return view('dashboard.clinic.index')->with(['data_list'=>Clinic::join('clinic_addresses','clinic_addresses.clinic_id','=','clinics.id')
                ->join('logos','clinics.id','=','logos.clinic_id')
                ->join('countries','clinic_addresses.country_id','=','countries.id')
                ->join('states','clinic_addresses.state_id','=','states.id')
                ->join('cities','clinic_addresses.city_id','=','cities.id')
                ->join('zones','clinic_addresses.zone_id','=','zones.id')
                ->join('areas','clinic_addresses.area_id','=','areas.id')
                ->join('user_infos','user_infos.user_id','=','clinics.user_id')
                ->where('clinics.user_id','=',session('user_id'))
                ->get(['clinic_addresses.*','clinics.*',
                    'logos.*','countries.name as country',
                    'states.name as state','cities.name as city','zones.name as zone',
                    'areas.name as area','user_infos.*'])]);
        }
        else{
            return view('dashboard.clinic.index')->with(['data_list'=>Clinic::join('clinic_addresses','clinic_addresses.clinic_id','=','clinics.id')
                ->join('logos','clinics.id','=','logos.clinic_id')
                ->join('countries','clinic_addresses.country_id','=','countries.id')
                ->join('states','clinic_addresses.state_id','=','states.id')
                ->join('cities','clinic_addresses.city_id','=','cities.id')
                ->join('zones','clinic_addresses.zone_id','=','zones.id')
                ->join('areas','clinic_addresses.area_id','=','areas.id')
                ->join('user_infos','user_infos.user_id','=','clinics.user_id')
                ->get(['clinic_addresses.*','clinics.*',
                    'logos.*','countries.name as country',
                    'states.name as state','cities.name as city','zones.name as zone',
                    'areas.name as area','user_infos.*'])]);
        }
    }
    public function addClinic(){
        session()->flash('countries',Country::all()->sortBy('name'));
        session()->flash('states',State::all()->sortBy('name'));
        session()->flash('cities',City::all()->sortBy('name'));
        session()->flash('zones',Zone::all()->sortBy('name'));
        session()->flash('areas',Area::all()->sortBy('name'));
        return view('dashboard.clinic.add-clinic');
    }

    public function storeClinic(Request $request){
if (session('user_role')=='business'){
    $clinic=Clinic::create([
        'user_id'=>session('user_id'),
        'name'=>$request->name,
        'email'=>$request->email,
        'phone'=>$request->phone,
        'facilities'=>$request->facilities
    ]);
}
else{
    $clinic=Clinic::create([
        'user_id'=>User::where('username',$request->owner)->value('id'),
        'name'=>$request->name,
        'email'=>$request->email,
        'phone'=>$request->phone,
        'facilities'=>$request->facilities
    ]);
}
ClinicAddress::create([
    'clinic_id'=>$clinic->id,
    'country_id'=>$request->country,
    'state_id'=>$request->state,
    'city_id'=>$request->city,
    'zone_id'=>$request->zone,
    'area_id'=>$request->area,
    'post_code'=>$request->post_code,
    'house'=>$request->house,
]);
        if($request->hasFile('logo')){
            $logo_name=uniqid()."-".$request->file('logo')->getClientOriginalName();
            $file_type=$request->file('logo')->getClientOriginalExtension();
            if((strtolower($file_type)=='png'||strtolower($file_type)=='jpg')||strtolower($file_type)=='jpeg'){
                $request->file('logo')->storeAs('logos',$clinic->id.'/'.$logo_name);

                Logo::create([
                    'clinic_id'=>$clinic->id,
                    'link'=>env('APP_URL').'/storage/logos/'.$clinic->id.'/'.$logo_name,
                    'path'=>'/storage/logos/'.$clinic->id.'/'.$logo_name
                ]);
            }
        }
        else{
            Logo::create([
                'clinic_id'=>$clinic->id,
                'link'=>env('APP_URL')."/storage/logos/default.png",
                'path'=>"/storage/logos/default.png"
            ]);
        }
        return redirect()->back()->with('success','The following clinic as been registered successfully: '.$request->name);

    }

    public function addDepartment(){
        if (session('user_role')=='business'){
            session()->flash('clinics',Clinic::where('user_id',session('user_id'))->orderBy('name')->get());

            return view('dashboard.clinic.add-department')->with(['data_list'=>Department::join('clinics','departments.clinic_id','=','clinics.id')
                ->where('clinics.user_id','=',session('user_id'))
                ->select('departments.name as department_name','departments.id as department_id','clinics.id as clinic_id','clinics.name as clinic_name')
                ->get()]);

        }
        elseif (session('user_role')=='admin'||session('user_role')=='super_admin'){

            session()->flash('clinics',Clinic::all()->sortBy('name'));

            return view('dashboard.clinic.add-department')->with(['data_list'=>Department::join('clinics','departments.clinic_id','=','clinics.id')
                ->select('departments.name as department_name','departments.id as department_id','clinics.id as clinic_id','clinics.name as clinic_name')
                ->get()]);
        }


    }

    public function storeDepartment(Request $request){

        if (count(Department::where('name',$request->department)
        ->where('clinic_id',$request->clinic_id)->get())>0){
            return redirect()->back()->with('error','department with similar name already exists in your clinic');
        }

        Department::create([
           'clinic_id'=>$request->clinic_id,
            'name'=>$request->department,
            'user_id'=>session('user_id'),
            'keywords'=>$request->keywords.', '.strtolower($request->department)
        ]);
        return redirect()->back()->with('success','The following department has been successfully added');
    }



    public function getDepartments($clinic_id){

        echo '<select class="form-control" name="department_id" id="department_options" required>';
        echo '<option disabled selected value> -- Select Department -- </option>';
        foreach (Department::where('clinic_id',$clinic_id)->get() as $department){
            echo '<option value="'.$department->id.'">'.$department->name.'</option>';
        }
        echo '</select>';

    }
}
