<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Route;
use App\Models\Bus;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TripController extends Controller
{
    function __construct(){
        $this->middleware(['Setting','auth']);
    }

    public function index(){
        $data['page_title'] = "Trip List";
        $data['trips'] = Trip::latest()->get();
        $data['routes'] = Route::latest()->get();
        $data['routesArr'] = $this->getRoutes();
        $data['busesArr'] = $this->getBuses();
        $data['buses'] = Bus::latest()->get();

        //dd($data['routes'][1]);
        return view('admin.trip.index',$data);
    }

    public function store( Request $request){

        $valid = $request->validate([
            'start_time' => 'required',
            'route' => 'required',
            'driver' => 'required',
            'helper' => 'required',
            'contacter' => 'required',
            'bus' => 'required',
        ]);

        if(!$valid){
            return response()->json();
        }


        Trip::create([
            'start_time' => Carbon::parse($request->start_time)->format('Y-m-d H:i:s'),
            'end_time' =>  Carbon::parse($request->end_time)->format('Y-m-d H:i:s'),
            'route' => $request->route,
            'driver' => $request->driver,
            'helper' => $request->helper,
            'contacter' => $request->contacter,
            'bus' => $request->bus
        ]);
        return response()->json();
    }

    public function update(Request $request,$id){

        $valid = $request->validate([
            'start_time' => 'required',
            'route' => 'required',
            'driver' => 'required',
            'helper' => 'required',
            'contacter' => 'required',
            'bus' => 'required',
        ]);

        if(!$valid){
            return response()->json();
        }

        $trip = Trip::findOrFail($request->id);
        $in = $request->all();
        $in['start_time'] = Carbon::parse($request->start_time)->format('Y-m-d H:i:s');
        $in['end_time'] =  Carbon::parse($request->end_time)->format('Y-m-d H:i:s');

        $trip->fill($in)->save();
        return response()->json();

    }

    
    public function destroy($id){
        $trip = Trip::findOrFail($id);
        $trip->delete();
        
        session()->flash('message','Trip deleted successfully !!');
        return redirect()->back();
    }

    public function getRoutes(){
        $routes = Route::latest()->get();

        $routesArr = [];
        foreach($routes as $route){
            $routesArr[$route->id] = $route->name;
        }

        return $routesArr;
    }

    public function getBuses(){
        $buses = Bus::latest()->get();

        $busesArr = [];
        foreach($buses as $bus){
            $busesArr[$bus->id] = $bus->name;
        }

        return $busesArr;
    }
}
