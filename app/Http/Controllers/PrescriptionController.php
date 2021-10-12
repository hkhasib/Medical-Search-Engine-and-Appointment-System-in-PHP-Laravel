<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function editor(Request $request){
        if (isset($request->appointment_id)&& Appointment::find($request->appointment_id) !== null){
            return view('dashboard.prescriptions.editor')->with('appointment_id',$request->appointment_id);
        }
        return redirect()->back()->with('error','Choose Appointment');

    }

    public function store(Request $request){
        $appointment=Appointment::where('id',$request->appointment_id)->first();


        Prescription::create([
            'appointment_id'=>$request->appointment_id,
           'user_id'=> $appointment->user_id,
            'doctor_id'=>$appointment->doctor_id,
            'department_id'=>Employee::where('clinic_id',$appointment->clinic_id)->where('user_id','=',
                Doctor::where('id',$appointment->doctor_id)->value('user_id'))->value('department_id'),
            'description'=>$request->description,
            'clinic_id'=>$appointment->clinic_id
        ]);
        Appointment::where('id',$request->appointment_id)->update([
            'status'=>'completed'
        ]);
        return redirect()->route('appointments')->with('success','successfully created prescription');
    }

    public function index(){
if (session('user_role')=='patient'){
    return view('dashboard.prescriptions.prescription-list')
        ->with('prescriptions',Prescription::join('user_infos','prescriptions.user_id','=','user_infos.user_id')
            ->where('prescriptions.user_id',session('user_id'))->orderBy('prescriptions.created_at','desc')
            ->get(['prescriptions.*','user_infos.first_name','user_infos.last_name']))
        ->with('doctors',Prescription::join('doctors','prescriptions.doctor_id','=','doctors.id')
            ->join('user_infos','doctors.user_id','=','user_infos.user_id')
            ->where('prescriptions.user_id',session('user_id'))
            ->orderBy('prescriptions.created_at','desc')
            ->get());;
}
        if (session('user_role')=='doctor'){
            return view('dashboard.prescriptions.prescription-list')
                ->with('prescriptions',Prescription::join('user_infos','prescriptions.user_id','=','user_infos.user_id')
                    ->join('doctors','prescriptions.doctor_id','doctors.id')
                    ->where('doctors.user_id',session('user_id'))->orderBy('prescriptions.created_at','desc')
                    ->get(['prescriptions.*','user_infos.first_name','user_infos.last_name']))
                ->with('doctors',Prescription::join('doctors','prescriptions.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->where('doctors.user_id',session('user_id'))
                    ->orderBy('prescriptions.created_at','desc')
                    ->get());;
        }


    }

    public function viewPrescription($id){

        if (session('user_role')=='patient'&&(Prescription::where('id',$id)->value('status')!='approved'||Prescription::where('id',$id)->value('user_id')!=session('user_id'))){
            return redirect()->back()->with('error','You do not have permission to view this prescription');
        }

        return view('dashboard.prescriptions.view-prescription')->with('prescription',Prescription::join('doctors','prescriptions.doctor_id','=','doctors.id')
            ->join('clinics','prescriptions.clinic_id','=','clinics.id')
            ->join('departments','prescriptions.department_id','=','departments.id')
            ->join('user_infos','doctors.user_id','=','user_infos.user_id')
            ->join('clinic_addresses','clinics.id','=','clinic_addresses.clinic_id')
            ->join('countries','clinic_addresses.country_id','=','countries.id')
            ->join('states','clinic_addresses.state_id','=','states.id')
            ->join('cities','clinic_addresses.city_id','=','cities.id')
            ->join('zones','clinic_addresses.zone_id','=','zones.id')
            ->join('areas','clinic_addresses.area_id','=','areas.id')
            ->where('prescriptions.id',$id)
            ->first(['prescriptions.id as prescription_id','prescriptions.*','clinics.name as clinic_name','countries.name as country',
                'states.name as state','cities.name as city','zones.name as zone',
                'areas.name as area','clinic_addresses.*','departments.name as department_name','user_infos.first_name as doctor_first_name'
                ,'user_infos.last_name as doctor_last_name','clinics.email as clinic_email','clinics.phone as clinic_phone'
            ,'user_infos.phone as doctor_phone','user_infos.email as doctors_email']))

            ->with('user',Prescription::join('user_infos','prescriptions.user_id','=','user_infos.user_id')
                ->where('prescriptions.id',$id)
                ->first(['user_infos.*']));
    }

    public function prescriptionListBilling(){

        if (session('user_role')=='front_desk'){
            return view('dashboard.prescriptions.prescription-list-billing')->with('prescriptions',Prescription::join('user_infos','prescriptions.user_id','=','user_infos.user_id')
                ->join('employees','prescriptions.clinic_id','=','employees.clinic_id')
                ->where('employees.user_id','=',session('user_id'))
                ->select('prescriptions.*','user_infos.first_name','user_infos.last_name','user_infos.phone','user_infos.email','user_infos.user_id as patient_id')
                ->orderBy('created_at','desc')
                ->get())
                ->with('doctors',Prescription::join('doctors','prescriptions.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->orderBy('prescriptions.created_at','desc')
                    ->get());
        }
        else{
            return view('dashboard.prescriptions.prescription-list-billing')->with('prescriptions',Prescription::join('user_infos','prescriptions.user_id','=','user_infos.user_id')
                ->select('prescriptions.*','user_infos.first_name','user_infos.last_name','user_infos.phone','user_infos.email','user_infos.user_id as patient_id')
                ->orderBy('created_at','desc')
                ->get())
                ->with('doctors',Prescription::join('doctors','prescriptions.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->orderBy('prescriptions.created_at','desc')
                    ->get());
        }



    }
}
