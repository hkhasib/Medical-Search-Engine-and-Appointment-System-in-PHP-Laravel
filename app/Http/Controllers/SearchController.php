<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class SearchController extends Controller
{
    public function search(Request $request){

        if (strlen($request->keyword)<3){
            return redirect()->back()->with('error','Keyword length must be at least three!');
        }

        $sub_keywords = explode(" ",str_replace(array('&', '!','@','-','\''),array(' ', ' ', ' ', ' ',' '), $request->keyword));

        $doctors = [];
        $dep_doctors =[];

        $i=0;


    foreach ($sub_keywords as $keyword){

        if(($keyword!=null||$keyword!="")&&strlen($keyword)>2){
            $result_doctor = UserInfo::where('first_name',$keyword)
                ->orWhere('first_name','like','%'.strtolower($keyword).'%')
                ->orWhere('first_name','like','%'.strtolower($keyword))
                ->orWhere('first_name','like',strtolower($keyword).'%')
                ->orWhere('last_name','=',strtolower($keyword))
                ->orWhere('last_name','like','%'.strtolower($keyword).'%')
                ->orWhere('last_name','like','%'.strtolower($keyword))
                ->orWhere('last_name','like',strtolower($keyword).'%')
                ->join('user_roles','user_infos.user_id','=','user_roles.user_id')
                ->join('employees','user_infos.user_id','=','employees.user_id')
                ->join('doctors','doctors.user_id','=','user_infos.user_id')
                ->join('avatars','doctors.user_id','=','avatars.user_id')
                ->where('user_roles.name','=','doctor')
                ->where('employees.employment_status','=','active')

                ->distinct('email')
                ->select('email','first_name','last_name','link','employees.user_id as doctor_id',
                    'designation','specialities')
                ->get();
            foreach ($result_doctor as $result){
                array_push($doctors,$result);
            }
            $result_department=Department::join('employees','departments.id','=','employees.department_id')
                ->join('user_roles','employees.user_id','=','user_roles.user_id')
                ->join('user_infos','employees.user_id','=','user_infos.user_id')
                ->join('doctors','doctors.user_id','=','user_infos.user_id')
                ->join('avatars','doctors.user_id','=','avatars.user_id')
                ->where('departments.keywords','like','%'.strtolower($keyword).'%')
                ->orWhere('departments.keywords','like','%'.strtolower($keyword))
                ->orWhere('departments.keywords','like',strtolower($keyword).'%')
                ->orWhere('doctors.designation','like','%'.strtolower($keyword).'%')
                ->orWhere('doctors.designation','like',strtolower($keyword).'%')
                ->orWhere('doctors.designation','like','%'.strtolower($keyword))
                ->select('email','first_name','last_name','link','employees.user_id as doctor_id',
                    'designation','specialities')
                ->distinct('email')
                ->get();
            foreach ($result_department as $result){
                array_push($dep_doctors,$result);
            }
            $i++;
    }
    }
    $k=0;
            if ($i>=sizeof($sub_keywords)&&(count($doctors)==0&&count($dep_doctors)==0)){

                foreach ($sub_keywords as $keyword) {
                    if (($keyword != null || $keyword != "") && strlen($keyword) > 2) {
                        $result_doctor = UserInfo::where('first_name', substr($keyword, 0, 3))
                            ->orWhere('first_name', 'like', '%' . strtolower(substr($keyword, 0, 3)) . '%')
                            ->orWhere('first_name', 'like', '%' . strtolower(substr($keyword, 0, 3)))
                            ->orWhere('first_name', 'like', strtolower(substr($keyword, 0, 3)) . '%')
                            ->orWhere('last_name', '=', strtolower(substr($keyword, 0, 3)))
                            ->orWhere('last_name', 'like', '%' . strtolower(substr($keyword, 0, 3)) . '%')
                            ->orWhere('last_name', 'like', '%' . strtolower(substr($keyword, 0, 3)))
                            ->orWhere('last_name', 'like', strtolower(substr($keyword, 0, 3)) . '%')
                            ->join('user_roles', 'user_infos.user_id', '=', 'user_roles.user_id')
                            ->join('employees', 'user_infos.user_id', '=', 'employees.user_id')
                            ->join('doctors', 'doctors.user_id', '=', 'user_infos.user_id')
                            ->join('avatars', 'doctors.user_id', '=', 'avatars.user_id')
                            ->where('user_roles.name', '=', 'doctor')
                            ->where('employees.employment_status', '=', 'active')
                            ->distinct('email')
                            ->select('email', 'first_name', 'last_name', 'link', 'employees.user_id as doctor_id',
                                'designation', 'specialities')
                            ->get();
                        foreach ($result_doctor as $result) {
                            array_push($doctors, $result);
                        }

                        $result_department = Department::join('employees', 'departments.id', '=', 'employees.department_id')
                            ->join('user_roles', 'employees.user_id', '=', 'user_roles.user_id')
                            ->join('user_infos', 'employees.user_id', '=', 'user_infos.user_id')
                            ->join('doctors', 'doctors.user_id', '=', 'user_infos.user_id')
                            ->join('avatars', 'doctors.user_id', '=', 'avatars.user_id')
                            ->where('departments.keywords', 'like', '%' . strtolower(substr($keyword, 0, 3)) . '%')
                            ->orWhere('departments.keywords', 'like', '%' . strtolower(substr($keyword, 0, 3)))
                            ->orWhere('departments.keywords', 'like', strtolower(substr($keyword, 0, 3)) . '%')
                            ->select('email', 'first_name', 'last_name', 'link', 'employees.user_id as doctor_id',
                                'designation', 'specialities')
                            ->distinct('email')
                            ->get();
                        foreach ($result_department as $result) {
                            array_push($dep_doctors, $result);
                        }
                        $k++;
                    }
                }
            }

        if ($k>=sizeof($sub_keywords)&&((count($doctors)<2&&count($dep_doctors)<2))){
            foreach ($sub_keywords as $keyword){
                $result_doctor = UserInfo::join('user_roles','user_infos.user_id','=','user_roles.user_id')
                    ->join('employees','user_infos.user_id','=','employees.user_id')
                    ->join('doctors','doctors.user_id','=','user_infos.user_id')
                    ->join('avatars','doctors.user_id','=','avatars.user_id')
                    ->where('user_roles.name','like',strtolower(substr($keyword, 0, 4)).'%')
                    ->orWhere('user_roles.name','like','%'.strtolower(substr($keyword, 0, 4)).'%')
                    ->orWhere('user_roles.name','like','%'.strtolower(substr($keyword, 0, 4)))
                    ->orWhere('user_roles.name','like','%'.strtolower(substr($keyword, -6)))
                    ->orWhere('doctors.designation','like','%'.strtolower(substr($keyword, 0, 4)).'%')
                    ->orWhere('doctors.designation','like',strtolower(substr($keyword, 0, 4)).'%')
                    ->orWhere('doctors.designation','like','%'.strtolower(substr($keyword, 0, 4)))
                    ->where('employees.employment_status','=','active')
                    ->distinct('email')
                    ->select('email','first_name','last_name','link','employees.user_id as doctor_id',
                        'designation','specialities')
                    ->get();
                foreach ($result_doctor as $result){
                    array_push($doctors,$result);
                }
            }
        }

        if(count($doctors)<1&&count($dep_doctors)<1){
            foreach ($sub_keywords as $keyword) {
                if (($keyword != null || $keyword != "") && strlen($keyword) > 2) {
                    $result_doctor = UserInfo::where('first_name', substr($keyword, 0, 3))
                        ->orWhere('first_name', 'like', '%' . strtolower(substr($keyword, 0, 3)) . '%')
                        ->orWhere('first_name', 'like', '%' . strtolower(substr($keyword, 0, 3)))
                        ->orWhere('first_name', 'like', strtolower(substr($keyword, 0, 3)) . '%')
                        ->orWhere('last_name', '=', strtolower(substr($keyword, 0, 3)))
                        ->orWhere('last_name', 'like', '%' . strtolower(substr($keyword, 0, 3)) . '%')
                        ->orWhere('last_name', 'like', '%' . strtolower(substr($keyword, 0, 3)))
                        ->orWhere('last_name', 'like', strtolower(substr($keyword, 0, 3)) . '%')
                        ->join('user_roles', 'user_infos.user_id', '=', 'user_roles.user_id')
                        ->join('employees', 'user_infos.user_id', '=', 'employees.user_id')
                        ->join('doctors', 'doctors.user_id', '=', 'user_infos.user_id')
                        ->join('avatars', 'doctors.user_id', '=', 'avatars.user_id')
                        ->where('user_roles.name', '=', 'doctor')
                        ->where('employees.employment_status', '=', 'active')
                        ->distinct('email')
                        ->select('email', 'first_name', 'last_name', 'link', 'employees.user_id as doctor_id',
                            'designation', 'specialities')
                        ->get();
                    foreach ($result_doctor as $result) {
                        array_push($doctors, $result);
                    }

                    $result_department = Department::join('employees', 'departments.id', '=', 'employees.department_id')
                        ->join('user_roles', 'employees.user_id', '=', 'user_roles.user_id')
                        ->join('user_infos', 'employees.user_id', '=', 'user_infos.user_id')
                        ->join('doctors', 'doctors.user_id', '=', 'user_infos.user_id')
                        ->join('avatars', 'doctors.user_id', '=', 'avatars.user_id')
                        ->where('departments.keywords', 'like', '%' . strtolower(substr($keyword, 0, 3)) . '%')
                        ->orWhere('departments.keywords', 'like', '%' . strtolower(substr($keyword, 0, 3)))
                        ->orWhere('departments.keywords', 'like', strtolower(substr($keyword, 0, 3)) . '%')
                        ->select('email', 'first_name', 'last_name', 'link', 'employees.user_id as doctor_id',
                            'designation', 'specialities')
                        ->distinct('email')
                        ->get();
                    foreach ($result_department as $result) {
                        array_push($dep_doctors, $result);
                    }
                }
            }
        }


            if(count(array_intersect($doctors,$dep_doctors))!=0){
                return view('front.search')->with('result',array_unique(array_intersect($doctors,$dep_doctors)))->with('count',count(array_intersect($doctors,$dep_doctors)));
            }
            return view('front.search')->with('result',array_unique(array_merge($doctors,$dep_doctors)))->with('count',count(array_unique(array_merge($doctors,$dep_doctors))));
    }
}
