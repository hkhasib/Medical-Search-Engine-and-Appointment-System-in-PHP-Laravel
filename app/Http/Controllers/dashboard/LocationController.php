<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function index(){

    }
    public function addCountry(){
        $countries=Country::all()->sortBy('name');
        if($countries!=[null]){

            return view('dashboard.location.add-country')->with(['data_list'=>$countries]);
        }
        return "nothing found";

    }
    public function storeCountry(Request $request){
        $valid = Validator::make($request->all(),[
            'country'=>'required|min:3'
        ],[
            'country.required'=>'Country Name Required. And It must be the full name. For example, Use United States. Not USA.',
        ]);
        if($valid->fails()){
            return redirect()->back()->withErrors($valid);
        }
        Country::create([
            'name'=>$request->country
        ]);
        return redirect()->back();
    }

    public function addState(){
        session()->flash('countries',Country::all()->sortBy('name'));

        return view('dashboard.location.add-state')->with(['data_list'=>DB::table('states')->join('countries','countries.id','=','states.country_id')
            ->select('states.name as state_name','states.id as state_id','countries.name as country_name','countries.id as country_id')
            ->orderBy('states.name')
            ->get()]);
    }
    public function storeState(Request $request){
        $valid = Validator::make($request->all(),[
            'state'=>'required|min:3'
        ],[
            'state.required'=>'State Name Required. And It must be the full name.',
        ]);
        if($valid->fails()){
            return redirect()->back()->withErrors($valid);
        }
        State::create([
            'country_id'=>$request->country,
            'name'=>$request->state
        ]);
        return redirect()->back();
    }

    public function addCity(){
        session()->flash('countries',Country::all()->sortBy('name'));
        session()->flash('states',State::all()->sortBy('name'));

        return view('dashboard.location.add-city')->with(['data_list'=>City::join('states','states.id','=','cities.state_id')
        ->join('countries','countries.id','=','states.country_id')
        ->get(['countries.name as country_name','states.name as state_name','cities.name as city_name'])]);
    }
    public function storeCity(Request $request){
        $valid = Validator::make($request->all(),[
            'city'=>'required|min:2'
        ],[
            'city.required'=>'City Name Required. And It must be the full name.',
        ]);
        if($valid->fails()){
            return redirect()->back()->withErrors($valid);
        }
        City::create([
            'state_id'=>$request->state,
            'name'=>$request->city
        ]);
        return redirect()->back();
    }

    public function addZone(){
        session()->flash('countries',Country::all()->sortBy('name'));
        session()->flash('states',State::all()->sortBy('name'));
        session()->flash('cities',City::all()->sortBy('name'));

        return view('dashboard.location.add-zone')->with(['data_list'=>Zone::join('cities','cities.id','=','zones.city_id')
            ->join('states','states.id','=','cities.state_id')
            ->join('countries','countries.id','=','states.country_id')
            ->get(['countries.name as country_name','states.name as state_name',
                'cities.name as city_name','zones.name as zone_name'])]);
    }
    public function storeZone(Request $request){
        $valid = Validator::make($request->all(),[
            'zone'=>'required|min:3'
        ],[
            'zone.required'=>'Zone Name Required. And It must be the full name.',
        ]);
        if($valid->fails()){
            return redirect()->back()->withErrors($valid);
        }
        Zone::create([
            'city_id'=>$request->city,
            'name'=>$request->zone
        ]);
        return redirect()->back();
    }

    public function addArea(){
        session()->flash('countries',Country::all()->sortBy('name'));
        session()->flash('states',State::all()->sortBy('name'));
        session()->flash('cities',City::all()->sortBy('name'));
        session()->flash('zones',Zone::all()->sortBy('name'));

        return view('dashboard.location.add-area')->with(['data_list'=>Area::join('zones','zones.id','=','areas.zone_id')
            ->join('cities','cities.id','=','zones.city_id')
            ->join('states','states.id','=','cities.state_id')
            ->join('countries','countries.id','=','states.country_id')
            ->get(['countries.name as country_name','states.name as state_name',
                'cities.name as city_name','zones.name as zone_name','areas.name as area_name'])]);
    }
    public function storeArea(Request $request){
        $valid = Validator::make($request->all(),[
            'area'=>'required|min:3'
        ],[
            'area.required'=>'Area Name Required. And It must be the full name.',
        ]);
        if($valid->fails()){
            return redirect()->back()->withErrors($valid);
        }
        Area::create([
            'zone_id'=>$request->zone,
            'name'=>$request->area
        ]);
        return redirect()->back();
    }

    public function getStates($country_id){

        echo '<select class="form-control" name="state" id="state_options" onchange="getCities()" required>';
        echo '<option disabled selected value> -- Select State/Division -- </option>';
        foreach (State::where('country_id',$country_id)->get() as $state){
            echo '<option value="'.$state->id.'">'.$state->name.'</option>';
        }
        echo '</select>';

    }
    public function getCities($state_id){

        echo '<select class="form-control" name="city" id="city_options" onchange="getZones()" required>';
        echo '<option disabled selected value> -- Select City -- </option>';
        foreach (City::where('state_id',$state_id)->get() as $city){
            echo '<option value="'.$city->id.'">'.$city->name.'</option>';
        }
        echo '</select>';

    }
    public function getZones($city_id){

        echo '<select class="form-control" name="zone" id="zone_options" onchange="getAreas()" required>';
        echo '<option disabled selected value> -- Select Zone -- </option>';
        foreach (Zone::where('city_id',$city_id)->get() as $zone){
            echo '<option value="'.$zone->id.'">'.$zone->name.'</option>';
        }
        echo '</select>';
    }
    public function getLocalArea($zone_id){

        echo '<select class="form-control" name="area" id="area_options" required>';
        echo '<option disabled selected value> -- Select Area -- </option>';
        foreach (Area::where('zone_id',$zone_id)->get() as $area){
            echo '<option value="'.$area->id.'">'.$area->name.'</option>';
        }
        echo '</select>';
    }
}
