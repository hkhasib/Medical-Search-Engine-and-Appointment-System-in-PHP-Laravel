<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Avatar;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\UserInfo;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        if (session('user_role')=='admin'||session('user_role')=='super_admin'){
            $data=['clinic_count'=>count(Clinic::all()),
                'doctor_count'=>count(Doctor::all()),'appointment_count'=>count(Appointment::all()),
                'patient_count'=>count(UserRole::where('name','patient')->get()),
                'upcoming_appointments'=>count(Appointment::where('status','pending')->get()),
                'new_patients'=>count(UserRole::whereMonth('created_at', date('m'))
                    ->whereYear('created_at', date('Y'))->where('name','patient')->get()),
                'new_doctors'=>count(UserRole::whereMonth('created_at', date('m'))
                    ->whereYear('created_at', date('Y'))->where('name','doctor')->get()),
                'new_clinics'=>count(Clinic::whereMonth('created_at', date('m'))
                    ->whereYear('created_at', date('Y'))->get())];
            $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                ->join('clinics','appointments.clinic_id','=','clinics.id')
                ->join('clinic_addresses','clinics.id','=','clinic_addresses.clinic_id')
                ->join('countries','clinic_addresses.country_id','=','countries.id')
                ->join('states','clinic_addresses.state_id','=','states.id')
                ->join('cities','clinic_addresses.city_id','=','cities.id')
                ->join('zones','clinic_addresses.zone_id','=','zones.id')
                ->join('areas','clinic_addresses.area_id','=','areas.id')
                ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                    'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                    'appointments.id as appointment_id','appointments.status as status','clinics.name as clinic_name',
                    'countries.name as country',
                    'states.name as state','cities.name as city','zones.name as zone',
                    'areas.name as area','clinic_addresses.*')
                ->whereMonth('appointments.appointment_time', date('m'))
                ->whereYear('appointments.appointment_time', date('Y'))
                ->where('appointments.status','=','pending')
                ->where('appointments.appointment_time','>',Carbon::now()->toDateTimeString())
                ->orderBy('appointments.appointment_time','asc')
                ->get();
            $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                ->whereMonth('appointments.appointment_time', date('m'))
                ->whereYear('appointments.appointment_time', date('Y'))
                ->where('appointments.appointment_time','>',Carbon::now()->toDateTimeString())
                ->where('appointments.status','=','pending')
                ->orderBy('appointments.appointment_time','asc')
                ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                    'user_infos.user_id as doctor_user_id')
                ->get();
        }
        if (session('user_role')=='business'){
            $data=['clinic_count'=>count(Clinic::where('user_id',session('user_id'))->get()),

                'doctor_count'=>count(Doctor::join('employees','doctors.user_id','=','employees.user_id')
                    ->join('clinics','employees.clinic_id','=','clinics.id')
                ->where('clinics.user_id','=',session('user_id'))->get())

                ,'appointment_count'=>count(Appointment::join('clinics','appointments.clinic_id','=','clinics.id')
                    ->where('clinics.user_id','=',session('user_id'))->get()),

                'patient_count'=>count(UserRole::join('appointments','user_roles.user_id','=','appointments.user_id')
                    ->join('clinics','appointments.clinic_id','=','clinics.id')
                    ->where('clinics.user_id','=',session('user_id'))
                    ->where('user_roles.name','patient')->get()),

                'upcoming_appointments'=>count(Appointment::join('clinics','appointments.clinic_id','=','clinics.id')
                    ->where('clinics.user_id','=',session('user_id'))
                    ->where('status','pending')->get()),

                'new_patients'=>count(UserRole::join('appointments','user_roles.user_id','=','appointments.user_id')
                    ->join('clinics','appointments.clinic_id','=','clinics.id')
                    ->where('clinics.user_id','=',session('user_id'))
                    ->where('user_roles.name','patient')->whereMonth('user_roles.created_at', date('m'))
                    ->whereYear('user_roles.created_at', date('Y'))->where('user_roles.name','patient')->get()),

                'new_doctors'=>count(Doctor::join('employees','doctors.user_id','=','employees.user_id')
                    ->join('clinics','employees.clinic_id','=','clinics.id')
                    ->where('clinics.user_id','=',session('user_id'))->whereMonth('employees.created_at', date('m'))
                    ->whereYear('employees.created_at', date('Y'))->get()),

                'new_clinics'=>count(Clinic::where('user_id',session('user_id'))->whereMonth('created_at', date('m'))
                    ->whereYear('created_at', date('Y'))->get())];
            $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                ->join('clinics','appointments.clinic_id','=','clinics.id')
                ->join('clinic_addresses','clinics.id','=','clinic_addresses.clinic_id')
                ->join('countries','clinic_addresses.country_id','=','countries.id')
                ->join('states','clinic_addresses.state_id','=','states.id')
                ->join('cities','clinic_addresses.city_id','=','cities.id')
                ->join('zones','clinic_addresses.zone_id','=','zones.id')
                ->join('areas','clinic_addresses.area_id','=','areas.id')
                ->where('clinics.user_id','=',session('user_id'))
                ->whereMonth('appointments.appointment_time', date('m'))
                ->whereYear('appointments.appointment_time', date('Y'))
                ->where('appointments.appointment_time','>',Carbon::now()->toDateTimeString())
                ->where('appointments.status','=','pending')
                ->orderBy('appointments.appointment_time','asc')
                ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                    'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                    'appointments.id as appointment_id','appointments.status as status','clinics.name as clinic_name',
                    'countries.name as country',
                    'states.name as state','cities.name as city','zones.name as zone',
                    'areas.name as area','clinic_addresses.*')
                ->get();
            $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                ->join('clinics','appointments.clinic_id','clinics.id')
                ->where('clinics.user_id','=',session('user_id'))
                ->whereMonth('appointments.appointment_time', date('m'))
                ->whereYear('appointments.appointment_time', date('Y'))
                ->where('appointments.appointment_time','>',Carbon::now()->toDateTimeString())
                ->where('appointments.status','=','pending')
                ->orderBy('appointments.appointment_time','asc')
                ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                    'user_infos.user_id as doctor_user_id')
                ->get();
        }

        if (session('user_role')=='front_desk'){
            $data=['clinic_count'=>count(Clinic::join('employees','clinics.id','=','employees.clinic_id')
            ->where('employees.user_id','=',session('user_id'))->get()),

                'doctor_count'=>count(Doctor::join('employees','doctors.user_id','=','employees.user_id')
                    ->where('employees.clinic_id','=',Employee::where('user_id',session('user_id'))->value('employees.clinic_id'))
                ->get()),

                'appointment_count'=>count(Appointment::where('clinic_id',Employee::where('user_id',session('user_id'))->value('employees.clinic_id'))
                ->get()),

                'patient_count'=>Appointment::where('clinic_id',Employee::where('user_id',session('user_id'))->value('employees.clinic_id'))
                    ->distinct('user_id')
                    ->count('user_id')];
            $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                ->where('appointments.clinic_id','=',Employee::where('user_id',session('user_id'))->value('employees.clinic_id'))
                ->join('clinics','appointments.clinic_id','=','clinics.id')
                ->join('clinic_addresses','clinics.id','=','clinic_addresses.clinic_id')
                ->join('countries','clinic_addresses.country_id','=','countries.id')
                ->join('states','clinic_addresses.state_id','=','states.id')
                ->join('cities','clinic_addresses.city_id','=','cities.id')
                ->join('zones','clinic_addresses.zone_id','=','zones.id')
                ->join('areas','clinic_addresses.area_id','=','areas.id')
                ->whereMonth('appointments.appointment_time', date('m'))
                ->whereYear('appointments.appointment_time', date('Y'))
                ->where('appointments.appointment_time','>',Carbon::now()->toDateTimeString())
                ->where('appointments.status','=','pending')
                ->orderBy('appointments.appointment_time','asc')
                ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                    'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                    'appointments.id as appointment_id','appointments.status as status','clinics.name as clinic_name',
                    'countries.name as country',
                    'states.name as state','cities.name as city','zones.name as zone',
                    'areas.name as area','clinic_addresses.*')
                ->get();
            $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                ->whereMonth('appointments.appointment_time', date('m'))
                ->whereYear('appointments.appointment_time', date('Y'))
                ->where('appointments.appointment_time','>',Carbon::now()->toDateTimeString())
                ->where('appointments.status','=','pending')
                ->orderBy('appointments.appointment_time','asc')
                ->where('appointments.clinic_id','=',Employee::where('user_id',session('user_id'))->value('employees.clinic_id'))
                ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                    'user_infos.user_id as doctor_user_id')
                ->get();
        }


        if (session('user_role')=='doctor'){
            $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                ->join('doctors','appointments.doctor_id','=','doctors.id')
                ->join('clinics','appointments.clinic_id','=','clinics.id')
                ->join('clinic_addresses','clinics.id','=','clinic_addresses.clinic_id')
                ->join('countries','clinic_addresses.country_id','=','countries.id')
                ->join('states','clinic_addresses.state_id','=','states.id')
                ->join('cities','clinic_addresses.city_id','=','cities.id')
                ->join('zones','clinic_addresses.zone_id','=','zones.id')
                ->join('areas','clinic_addresses.area_id','=','areas.id')
                ->where('doctors.user_id','=',session('user_id'))
                ->whereMonth('appointments.appointment_time', date('m'))
                ->whereYear('appointments.appointment_time', date('Y'))
                ->where('appointments.appointment_time','>',Carbon::now()->toDateTimeString())
                ->where('appointments.status','=','pending')
                ->orderBy('appointments.appointment_time','asc')
                ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                    'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                    'appointments.id as appointment_id','appointments.status as status','clinics.name as clinic_name',
                    'countries.name as country',
                    'states.name as state','cities.name as city','zones.name as zone',
                    'areas.name as area','clinic_addresses.*')
                ->get();
            $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                ->where('doctors.user_id','=',session('user_id'))
                ->whereMonth('appointments.appointment_time', date('m'))
                ->whereYear('appointments.appointment_time', date('Y'))
                ->where('appointments.appointment_time','>',Carbon::now()->toDateTimeString())
                ->where('appointments.status','=','pending')
                ->orderBy('appointments.appointment_time','asc')
                ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                    'user_infos.user_id as doctor_user_id')
                ->get();

            $next_appointment=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                ->join('user_infos','appointments.user_id','=','user_infos.user_id')
                ->where('doctors.user_id','=',session('user_id'))
                ->where('appointments.status','=','pending')
            ->where('appointments.appointment_time','>',Carbon::now()->toDateTimeString())
                ->orderBy('appointments.appointment_time','asc')
                ->first();

        }

        if (session('user_role')=='patient'){
            $patients=Appointment::where('appointments.user_id','=',session('user_id'))
                ->join('user_infos','appointments.user_id','user_infos.user_id')
                ->join('clinics','appointments.clinic_id','=','clinics.id')
                ->join('clinic_addresses','clinics.id','=','clinic_addresses.clinic_id')
                ->join('countries','clinic_addresses.country_id','=','countries.id')
                ->join('states','clinic_addresses.state_id','=','states.id')
                ->join('cities','clinic_addresses.city_id','=','cities.id')
                ->join('zones','clinic_addresses.zone_id','=','zones.id')
                ->join('areas','clinic_addresses.area_id','=','areas.id')
                ->whereMonth('appointments.appointment_time', date('m'))
                ->whereYear('appointments.appointment_time', date('Y'))
                ->where('appointments.appointment_time','>',Carbon::now()->toDateTimeString())
                ->where('appointments.status','=','pending')
                ->orderBy('appointments.appointment_time','asc')
                ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                    'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                    'appointments.id as appointment_id','appointments.status as status','clinics.name as clinic_name',
                    'countries.name as country',
                    'states.name as state','cities.name as city','zones.name as zone',
                    'areas.name as area','clinic_addresses.*')
                ->get();
            $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                ->whereMonth('appointments.appointment_time', date('m'))
                ->whereYear('appointments.appointment_time', date('Y'))
                ->where('appointments.user_id','=',session('user_id'))
                ->where('appointments.appointment_time','>',Carbon::now()->toDateTimeString())
                ->where('appointments.status','=','pending')
                ->orderBy('appointments.appointment_time','asc')
                ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                    'user_infos.user_id as doctor_user_id')
                ->get();

            $next_appointment=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                ->where('appointments.user_id','=',session('user_id'))
                ->where('appointments.status','=','pending')
                ->where('appointments.appointment_time','>',Carbon::now()->toDateTimeString())
                ->orderBy('appointments.appointment_time','asc')
                ->first();
        }



        if (session('user_role')!='patient'&session('user_role')!='doctor'){
            return view('dashboard.dashboard')->with('data',$data)->with('patient_list',$patients)->with('doctor_list',$doctors);
        }
        else{
            return view('dashboard.dashboard')->with('patient_list',$patients)
                ->with('doctor_list',$doctors)
                ->with('next_appointment',$next_appointment);
        }
    }
}
