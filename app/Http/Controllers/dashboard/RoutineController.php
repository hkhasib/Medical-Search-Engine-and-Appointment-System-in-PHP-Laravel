<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Routine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoutineController extends Controller
{

        public function addRoutine(){
            session()->flash('clinics',Employee::join('clinics','employees.clinic_id','=','clinics.id')
                ->where('employees.user_id','=',session('user_id'))
                ->get()
                ->sortBy('name'));
            session()->flash('routines',Routine::join('clinics','routines.clinic_id','=','clinics.id')
                ->where('routines.user_id','=',session('user_id'))
                ->get()
                ->sortBy('day'));
            return view('dashboard.routine.routine-editor')->with(['data_list'=>Department::join('clinics','departments.clinic_id','=','clinics.id')
                ->select('departments.name as department_name','departments.id as department_id','clinics.id as clinic_id','clinics.name as clinic_name')
                ->get()]);
        }

        public function storeRoutine(Request $request){

            if (DB::select('Select * from routines where day = "'.$request->day.'" and from_time between "'.$request->from.'"
            and "'.$request->to.'"')!=null){
                return redirect()->back()->with('error','Time Conflicts with your another schedule!');
            }
            else if (DB::select('Select * from routines where day = "'.$request->day.'" and to_time between "'.$request->from.'"
            and "'.$request->to.'"')!=null){
                return redirect()->back()->with('error','Time Conflicts with your another schedule!');
            }
            else{
                $temp_from = strtotime($request->from);
                $temp_to=strtotime('+'.$request->interval.' minutes',strtotime($request->from));


                while ($temp_to<=strtotime($request->to)){
                    Routine::create([
                        'user_id'=>$request->user_id,
                        'clinic_id'=>$request->clinic_id,
                        'from_time'=>date('H:i',$temp_from),
                        'to_time'=>date('H:i',$temp_to),
                        'day'=>$request->day
                    ]);
                    $temp_from = strtotime('+'.$request->interval.' minutes',$temp_from);
                    $temp_to=strtotime('+'.$request->interval.' minutes',$temp_from);
                }
                if ($temp_to>strtotime($request->to)&&$temp_from<strtotime($request->to)){
                    Routine::create([
                        'user_id'=>$request->user_id,
                        'clinic_id'=>$request->clinic_id,
                        'from_time'=>date('H:i',$temp_from),
                        'to_time'=>date('H:i',strtotime($request->to)),
                        'day'=>$request->day
                    ]);
                }
                return redirect()->back()->with('success','Routine successfully Added');
            }
            }


}
