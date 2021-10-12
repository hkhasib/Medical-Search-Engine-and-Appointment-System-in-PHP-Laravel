<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (session('user_role')=='admin'||session('user_role')=='super_admin'){
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
                ->get();
            $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                ->join('user_infos','doctors.user_id','=','user_infos.user_id')
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
                ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                    'user_infos.user_id as doctor_user_id')
                ->get();
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
                ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                    'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                    'appointments.id as appointment_id','appointments.status as status','clinics.name as clinic_name',
                    'countries.name as country',
                    'states.name as state','cities.name as city','zones.name as zone',
                    'areas.name as area','clinic_addresses.*')
                ->get();
            $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                ->where('appointments.user_id','=',session('user_id'))
                ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                    'user_infos.user_id as doctor_user_id')
                ->get();
        }
        if (session('user_role')=='business'){
            $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                ->join('clinics','appointments.clinic_id','clinics.id')
                ->join('clinics','appointments.clinic_id','=','clinics.id')
                ->join('clinic_addresses','clinics.id','=','clinic_addresses.clinic_id')
                ->join('countries','clinic_addresses.country_id','=','countries.id')
                ->join('states','clinic_addresses.state_id','=','states.id')
                ->join('cities','clinic_addresses.city_id','=','cities.id')
                ->join('zones','clinic_addresses.zone_id','=','zones.id')
                ->join('areas','clinic_addresses.area_id','=','areas.id')
                ->where('clinics.user_id','=',session('user_id'))
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
                ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                    'user_infos.user_id as doctor_user_id')
                ->get();
        }

        if (session('user_role')=='front_desk'){
            $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                ->join('clinics','appointments.clinic_id','=','clinics.id')
                ->join('clinic_addresses','clinics.id','=','clinic_addresses.clinic_id')
                ->join('countries','clinic_addresses.country_id','=','countries.id')
                ->join('states','clinic_addresses.state_id','=','states.id')
                ->join('cities','clinic_addresses.city_id','=','cities.id')
                ->join('zones','clinic_addresses.zone_id','=','zones.id')
                ->join('areas','clinic_addresses.area_id','=','areas.id')
                ->where('appointments.clinic_id','=',Employee::where('user_id',session('user_id'))->value('employees.clinic_id'))
                ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                    'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                    'appointments.id as appointment_id','appointments.status as status','clinics.name as clinic_name',
                    'countries.name as country',
                    'states.name as state','cities.name as city','zones.name as zone',
                    'areas.name as area','clinic_addresses.*')
                ->get();
            $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                ->where('appointments.clinic_id','=',Employee::where('user_id',session('user_id'))->value('employees.clinic_id'))
                ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                    'user_infos.user_id as doctor_user_id')
                ->get();
        }



        return view('dashboard.appointments.index')->with('patient_list',$patients)->with('doctor_list',$doctors);
    }

    public function customList(){
    return view('dashboard.appointments.custom-data');
    }
    public function getCustomAppointments(Request $request){
        if ($request->data_range=='today'){
            if (session('user_role')=='admin'||session('user_role')=='super_admin'){
                $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                    ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                        'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                        'appointments.id as appointment_id','appointments.status as status')
                    ->whereDate('appointments.appointment_time',Carbon::today())
                    ->orderBy('appointments.appointment_time','asc')
                    ->get();
                $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->whereDate('appointments.appointment_time',Carbon::today())
                    ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                        'user_infos.user_id as doctor_user_id')
                    ->orderBy('appointments.appointment_time','asc')
                    ->get();
            }
            if (session('user_role')=='doctor'){
                $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                    ->join('doctors','appointments.doctor_id','=','doctors.id')
                    ->where('doctors.user_id','=',session('user_id'))
                    ->whereDate('appointments.appointment_time',Carbon::today())
                    ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                        'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                        'appointments.id as appointment_id','appointments.status as status')
                    ->get();
                $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->where('doctors.user_id','=',session('user_id'))
                    ->whereDate('appointments.appointment_time',Carbon::today())
                    ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                        'user_infos.user_id as doctor_user_id')
                    ->get();
            }
            if (session('user_role')=='patient'){
                $patients=Appointment::where('appointments.user_id','=',session('user_id'))
                    ->join('user_infos','appointments.user_id','user_infos.user_id')
                    ->whereDate('appointments.appointment_time',Carbon::today())
                    ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                        'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                        'appointments.id as appointment_id','appointments.status as status')
                    ->get();
                $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->whereDate('appointments.appointment_time',Carbon::today())
                    ->where('appointments.user_id','=',session('user_id'))
                    ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                        'user_infos.user_id as doctor_user_id')
                    ->get();
            }
            if (session('user_role')=='business'){
                $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                    ->join('clinics','appointments.clinic_id','clinics.id')
                    ->where('clinics.user_id','=',session('user_id'))
                    ->whereDate('appointments.appointment_time',Carbon::today())
                    ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                        'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                        'appointments.id as appointment_id','appointments.status as status')
                    ->get();
                $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->join('clinics','appointments.clinic_id','clinics.id')
                    ->where('clinics.user_id','=',session('user_id'))
                    ->whereDate('appointments.appointment_time',Carbon::today())
                    ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                        'user_infos.user_id as doctor_user_id')
                    ->get();
            }

            if (session('user_role')=='front_desk'){
                $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                    ->where('appointments.clinic_id','=',Employee::where('user_id',session('user_id'))->value('employees.clinic_id'))
                    ->whereDate('appointments.appointment_time',Carbon::today())
                    ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                        'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                        'appointments.id as appointment_id','appointments.status as status')
                    ->get();
                $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->where('appointments.clinic_id','=',Employee::where('user_id',session('user_id'))->value('employees.clinic_id'))
                    ->whereDate('appointments.appointment_time',Carbon::today())
                    ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                        'user_infos.user_id as doctor_user_id')
                    ->get();
            }
        }
        if ($request->data_range=='this_month'){
            if (session('user_role')=='admin'||session('user_role')=='super_admin'){
                $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                    ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                        'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                        'appointments.id as appointment_id','appointments.status as status')
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->get();
                $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                        'user_infos.user_id as doctor_user_id')
                    ->get();
            }
            if (session('user_role')=='doctor'){
                $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                    ->join('doctors','appointments.doctor_id','=','doctors.id')
                    ->where('doctors.user_id','=',session('user_id'))
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                        'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                        'appointments.id as appointment_id','appointments.status as status')
                    ->get();
                $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->where('doctors.user_id','=',session('user_id'))
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                        'user_infos.user_id as doctor_user_id')
                    ->get();
            }
            if (session('user_role')=='patient'){
                $patients=Appointment::where('appointments.user_id','=',session('user_id'))
                    ->join('user_infos','appointments.user_id','user_infos.user_id')
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                        'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                        'appointments.id as appointment_id','appointments.status as status')
                    ->get();
                $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->where('appointments.user_id','=',session('user_id'))
                    ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                        'user_infos.user_id as doctor_user_id')
                    ->get();
            }
            if (session('user_role')=='business'){
                $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                    ->join('clinics','appointments.clinic_id','clinics.id')
                    ->where('clinics.user_id','=',session('user_id'))
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                        'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                        'appointments.id as appointment_id','appointments.status as status')
                    ->get();
                $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->join('clinics','appointments.clinic_id','clinics.id')
                    ->where('clinics.user_id','=',session('user_id'))
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                        'user_infos.user_id as doctor_user_id')
                    ->get();
            }

            if (session('user_role')=='front_desk'){
                $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                    ->where('appointments.clinic_id','=',Employee::where('user_id',session('user_id'))->value('employees.clinic_id'))
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                        'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                        'appointments.id as appointment_id','appointments.status as status')
                    ->get();
                $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->where('appointments.clinic_id','=',Employee::where('user_id',session('user_id'))->value('employees.clinic_id'))
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                        'user_infos.user_id as doctor_user_id')
                    ->get();
            }
        }
        if ($request->data_range=='yesterday'){
            if (session('user_role')=='admin'||session('user_role')=='super_admin'){
                $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                    ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                        'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                        'appointments.id as appointment_id','appointments.status as status')
                    ->whereBetween('appointments.appointment_time',[Carbon::yesterday(), Carbon::yesterday()->addSeconds(86399)])
                    ->get();
                $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->whereBetween('appointments.appointment_time',[Carbon::yesterday(), Carbon::yesterday()->addSeconds(86399)])
                    ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                        'user_infos.user_id as doctor_user_id')
                    ->get();
            }
            if (session('user_role')=='doctor'){
                $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                    ->join('doctors','appointments.doctor_id','=','doctors.id')
                    ->where('doctors.user_id','=',session('user_id'))
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                        'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                        'appointments.id as appointment_id','appointments.status as status')
                    ->get();
                $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->where('doctors.user_id','=',session('user_id'))
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                        'user_infos.user_id as doctor_user_id')
                    ->get();
            }
            if (session('user_role')=='patient'){
                $patients=Appointment::where('appointments.user_id','=',session('user_id'))
                    ->join('user_infos','appointments.user_id','user_infos.user_id')
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                        'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                        'appointments.id as appointment_id','appointments.status as status')
                    ->get();
                $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->where('appointments.user_id','=',session('user_id'))
                    ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                        'user_infos.user_id as doctor_user_id')
                    ->get();
            }
            if (session('user_role')=='business'){
                $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                    ->join('clinics','appointments.clinic_id','clinics.id')
                    ->where('clinics.user_id','=',session('user_id'))
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                        'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                        'appointments.id as appointment_id','appointments.status as status')
                    ->get();
                $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->join('clinics','appointments.clinic_id','clinics.id')
                    ->where('clinics.user_id','=',session('user_id'))
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                        'user_infos.user_id as doctor_user_id')
                    ->get();
            }

            if (session('user_role')=='front_desk'){
                $patients=Appointment::join('user_infos','appointments.user_id','user_infos.user_id')
                    ->where('appointments.clinic_id','=',Employee::where('user_id',session('user_id'))->value('employees.clinic_id'))
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->select('user_infos.first_name as patient_first_name','user_infos.last_name as patient_last_name',
                        'user_infos.user_id as patient_user_id','appointments.appointment_time as appointment_time',
                        'appointments.id as appointment_id','appointments.status as status')
                    ->get();
                $doctors=Appointment::join('doctors','appointments.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->where('appointments.clinic_id','=',Employee::where('user_id',session('user_id'))->value('employees.clinic_id'))
                    ->whereMonth('appointments.appointment_time', date('m'))
                    ->whereYear('appointments.appointment_time', date('Y'))
                    ->select('user_infos.first_name as doctor_first_name','user_infos.last_name as doctor_last_name',
                        'user_infos.user_id as doctor_user_id')
                    ->get();
            }
        }
        return view('dashboard.appointments.custom-data')->with('patient_list',$patients)->with('doctor_list',$doctors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(session('user_id')==$request->doctor_id){
            return redirect()->back()->with('error','You cannot book this appointment');
        }

       if (Appointment::where([['user_id',session('user_id')],['status','pending'],['appointment_time','>',date('Y-m-d H:i:s',time())]])

               ->count()>2){
           return redirect()->back()->with('error','You already have three or more upcoming appointments!');
       }

        if (Appointment::where([['doctor_id',Doctor::where('user_id',$request->doctor_id)->value('id')],
            ['appointment_time',date('Y-m-d H:i:s',strtotime($request->appointment_date." ".$request->time))]])->count()!=0){
            return redirect()->back()->with('error','Time Conflict. Try using different time!');
        }
        if (!isset($request->time)){
            return redirect()->back()->with('error','Select a time!');
        }

        Appointment::create([
           'appointment_time'=>date('Y-m-d H:i:s',strtotime($request->appointment_date." ".$request->time)),
            'user_id'=>session('user_id'),
            'doctor_id'=>Doctor::where('user_id',$request->doctor_id)->value('id'),
            'clinic_id'=>$request->clinic_id,
            'note'=>$request->note,
            'booked_by'=>session('user_id'),
            'status'=>"pending"
        ]);
        return redirect()->back()->with('success','Successfully Booked!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (count(Appointment::where('id',$id)->get())==0){
            return redirect()->route('appointments')->with('error','No Appointment Found');
        }
        return view('dashboard.appointments.update-appointment')->with('data',Appointment::where('id',$id)->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->status=='cancelled'&&((strtotime(Appointment::where('id',$request->id)->value('appointment_time'))-time())<(24 * 60 * 60))){
            return redirect()->back()->with('error','You cannot cancel this appointment');
        }
        else{
            Appointment::where('id',$request->id)->update([
                'note'=>$request->note,
                'status'=>$request->status
            ]);

            return redirect()->back()->with('success','Appointment Status Updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
