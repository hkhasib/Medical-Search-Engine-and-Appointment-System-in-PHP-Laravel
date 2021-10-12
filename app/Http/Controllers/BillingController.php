<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Prescription;
use App\Models\UserInfo;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function createBill($prescription_id, $appointment_id, $user_id, $doctor_id){

        return view('dashboard.billing.create-invoice')->with('prescription',Prescription::where('id',$prescription_id)->first())
            ->with('doctor',Doctor::join('user_infos','doctors.user_id','=','user_infos.user_id')
                ->where('doctors.id','=',$doctor_id)
                ->first())
            ->with('patient',UserInfo::where('user_id',$user_id)->first())
            ->with('doctor_id',$doctor_id)
            ->with('user_id',$user_id)
            ->with('appointment_id',$appointment_id)
            ->with('prescription_id',$prescription_id);
    }

    public function store(Request $request){

        Invoice::create([
            'user_id'=>$request->user_id,
            'appointment_id'=>$request->appointment_id,
            'doctor_id'=>$request->doctor_id,
            'prescription_id'=>$request->prescription_id,
            'description'=>$request->description,
            'doctor_fee'=>$request->doctor_fee,
            'other_fee'=>$request->other_fee,
            'total'=>$request->total,
            'discount'=>$request->discount,
            'final_total'=>$request->final_total,
            'payment_status'=>'pending',
            'prepared_by'=>session('user_id')
        ]);

        Prescription::where('id',$request->prescription_id)->update([
           'status'=>'invoiced'
        ]);

        return redirect()->route('billing.prescriptions')->with('success','Bill Created');
    }

    public function viewInvoice($id){


        return view('dashboard.billing.view-invoice')->with('invoice',Invoice::join('appointments','invoices.appointment_id','=','appointments.id')
            ->join('clinics','appointments.clinic_id','=','clinics.id')
            ->join('clinic_addresses','clinics.id','=','clinic_addresses.clinic_id')
            ->join('countries','clinic_addresses.country_id','=','countries.id')
            ->join('states','clinic_addresses.state_id','=','states.id')
            ->join('cities','clinic_addresses.city_id','=','cities.id')
            ->join('zones','clinic_addresses.zone_id','=','zones.id')
            ->join('areas','clinic_addresses.area_id','=','areas.id')
            ->where('invoices.id',$id)
            ->first(['invoices.id as invoice_id','invoices.created_at as date','clinics.name as clinic_name','countries.name as country',
                'states.name as state','cities.name as city','zones.name as zone',
                'areas.name as area','clinic_addresses.*','invoices.*']))

            ->with('user',Invoice::join('user_infos','invoices.user_id','=','user_infos.user_id')
                ->join('user_addresses','user_infos.user_id','=','user_addresses.user_id')
            ->join('countries','user_addresses.country_id','=','countries.id')
            ->join('states','user_addresses.state_id','=','states.id')
            ->join('cities','user_addresses.city_id','=','cities.id')
            ->join('zones','user_addresses.zone_id','=','zones.id')
            ->join('areas','user_addresses.area_id','=','areas.id')
                ->where('invoices.id',$id)
            ->first(['user_infos.*','countries.name as country',
                'states.name as state','cities.name as city','zones.name as zone',
                'areas.name as area','user_addresses.*']));
    }

    public function viewBills(){
        if (session('user_role')=='patient'){

            return view('dashboard.billing.invoice-list')
                ->with('bills',Invoice::join('doctors','invoices.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                ->where('invoices.user_id','=',session('user_id'))->orderBy('created_at','desc')
                    ->get(['invoices.*','user_infos.first_name','user_infos.last_name']));
        }
        elseif (session('user_role')=='front_desk'){
            return view('dashboard.billing.invoice-list')
                ->with('bills',Invoice::join('doctors','invoices.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->join('appointments','invoices.appointment_id','=','appointments.id')
                    ->where('appointments.clinic_id','=',Employee::where('user_id',session('user_id'))->value('employees.clinic_id'))
                    ->orderBy('created_at','desc')
                    ->get(['invoices.*','user_infos.first_name','user_infos.last_name']));
        }
        elseif (session('user_role')=='business'){
            return view('dashboard.billing.invoice-list')
                ->with('bills',Invoice::join('doctors','invoices.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->join('appointments','invoices.appointment_id','=','appointments.id')
                    ->join('clinics','appointments.clinic_id','=','clinics.id')
                    ->where('clinics.user_id','=',session('user_id'))
                    ->orderBy('created_at','desc')
                    ->get(['invoices.*','user_infos.first_name','user_infos.last_name']));
        }
        elseif (session('user_role')=='admin'||session('user_role')=='super_admin'){
            return view('dashboard.billing.invoice-list')
                ->with('bills',Invoice::join('doctors','invoices.doctor_id','=','doctors.id')
                    ->join('user_infos','doctors.user_id','=','user_infos.user_id')
                    ->orderBy('created_at','desc')
                    ->get(['invoices.*','user_infos.first_name','user_infos.last_name']));
        }
    }

    public function completePayment(Request $request){
    Invoice::where('id',$request->invoice_id)->update([
       'payment_status'=>'completed'
    ]);
    Prescription::where('id',Invoice::where('id',$request->invoice_id)->value('prescription_id'))->update([
       'status'=>'approved'
    ]);
    return redirect()->route('billing.prescriptions')->with('success','Payment Status Updated!');
    }
}
