<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Country;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\Routine;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use function Ramsey\Uuid\v1;

class FrontController extends Controller
{
    public function index(){
        session()->flash('countries',Country::all()->sortBy('name'));
        return view('front.home');
    }

    public function doctorProfile($id){
        if(session()->has('user_id')){
            setcookie('last_page',"",time() - 3600,"/");
        }

        if(Doctor::join('employees','doctors.user_id','=','employees.user_id')
                ->where('employees.employment_status','=','active')
                ->where('doctors.user_id','=',$id)->count()==0){
            return abort('404');
        }
        $doctor = Doctor::join('user_infos','doctors.user_id','=','user_infos.user_id')
            ->join('employees','doctors.user_id','=','employees.user_id')
            ->join('avatars','doctors.user_id','=','avatars.user_id')
            ->join('user_addresses','doctors.user_id','=','user_addresses.user_id')
            ->where('employees.employment_status','=','active')
            ->where('doctors.user_id','=',$id)
            ->first();
        $places = Employee::join('clinics','employees.clinic_id','=','clinics.id')
            ->join('clinic_addresses','employees.clinic_id','=','clinic_addresses.clinic_id')
            ->join('countries','clinic_addresses.country_id','=','countries.id')
            ->join('states','clinic_addresses.state_id','=','states.id')
            ->join('cities','clinic_addresses.city_id','=','cities.id')
            ->join('zones','clinic_addresses.zone_id','=','zones.id')
            ->join('areas','clinic_addresses.area_id','=','areas.id')
            ->where('employees.user_id','=',$id)
            ->distinct()
            ->get(['clinic_addresses.*','clinics.id as clinic_id','clinics.name as clinic','countries.name as country',
                'states.name as state','cities.name as city','zones.name as zone',
                'areas.name as area']);

        session()->flash('clinics',$places);

        $days = Routine::where('routines.user_id',$id)->distinct()->select('day')->get();



        $from_times =[];
        $to_times =[];

        for ($i=0;$i<sizeof($days);$i++){
            array_push($from_times,Routine::where([['routines.user_id',$id],['routines.day',$days[$i]['day']]])
                ->select('from_time')
                ->orderBy('from_time','asc')->first());
        }
        for ($i=0;$i<sizeof($days);$i++){
            array_push($to_times,Routine::where([['routines.user_id',$id],['routines.day',$days[$i]['day']]])
                ->select('to_time')
                ->orderBy('to_time','desc')->first());
        }

        return view('front.doctor-profile')->with('from_times',$from_times)->with('to_times',$to_times)
            ->with('days',$days)->with('doctor',$doctor)
            ->with('place',$places)->with('doctor_id',$id);
    }

    public function searchIndex(){
        return view('front.search');
    }

    public function getTimes($clinic_id,$doctor_id,$date){

        if (date('Y-m-d',strtotime($date))<=date('Y-m-d',time())){
            echo "<script>alert('Do not choose old date or the current date.');document.getElementById('routine_date').value = null;</script>";
        }

        $routines = Routine::where([['day',strtolower(date('l',strtotime($date)))],['routines.clinic_id',$clinic_id],['routines.user_id',$doctor_id]])->get();
        $appointments = Appointment::where('doctor_id',Doctor::where('user_id',$doctor_id)->value('id'))
            ->whereBetween('appointment_time',[date('Y-m-d H:i:s', strtotime($date)),
                date('Y-m-d',strtotime($date))." 23:59:59"])
            ->get();

        foreach ($appointments as $appointment){
            $i=0;
            foreach ($routines as $routine){

                if ($routine->day==strtolower(date('l',strtotime($appointment->appointment_time)))&&
                $routine->from_time==strtolower(date('H:i:s',strtotime($appointment->appointment_time)))){
                        unset($routines[$i]);
                }
                $i++;
            }
        }
            echo '<select class="form-control" name="time" required>';
            echo '<option disabled selected value> -- Select Time -- </option>';
            foreach ($routines as $routine){
                echo '<option value="'.strtolower($routine->from_time).'">'.date('h:i A',strtotime($routine->from_time)).'</option>';
            }
            echo '</select>';

        if(sizeof($routines)==0){
            echo "<script>alert('No Free Slots');</script>";
        }

    }
    public function getRoutines($clinic_id,$doctor_id){
        $days = Routine::where([['routines.clinic_id',$clinic_id],['routines.user_id',$doctor_id]])->distinct()->select('day')->get();

        $from_time=[];
        $to_time=[];
        for ($i=0;$i<sizeof($days);$i++){
            array_push($from_time,Routine::where([['day',$days[$i]->day],['clinic_id',$clinic_id],['routines.user_id',$doctor_id]])->orderBy('from_time')->first('from_time'));
        }
        for ($i=0;$i<sizeof($days);$i++){
            array_push($to_time,Routine::where([['day',$days[$i]->day],['clinic_id',$clinic_id],['routines.user_id',$doctor_id]])->orderBy('to_time','desc')->first('to_time'));
        }


$i=0;
        foreach ($days as $day){
            echo '<p>'.ucfirst($day['day']).' :'.date('h:i A',strtotime($from_time[$i]->from_time)).' - '.date('h:i A',strtotime($to_time[$i]->to_time)).'</p>';
            $i++;
        }

    }
}
