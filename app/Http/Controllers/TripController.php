<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Route;
use App\Models\Bus;
use App\Models\UserDetails;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    function __construct(){
        $this->middleware(['Setting','auth']);
    }

    public function index(){
        $data['page_title'] = "Trip List";
        $user = Auth::user();
        if ($user->hasRole('admin')){
            $data['trips'] = Trip::with('bus','driver','helper','checker')->latest()->get();
        }else if($user->hasRole('checker')){
            $data['trips'] = Trip::with('bus','driver','helper','checker')->where('checker_id',$user->id)->latest()->get();
        }else if($user->hasRole('helper')){
            $data['trips'] = Trip::with('bus','driver','helper','checker')->where('helper_id',$user->id)->latest()->get();
        }else if($user->hasRole('driver')){
            $data['trips'] = Trip::with('bus','driver','helper','checker')->where('driver_id',$user->id)->latest()->get();
        }
        else{
            $data['trips'] = Trip::with('bus','driver','helper','checker')->where('owner_id',$user->id)->latest()->get();

        }
        $data['routes'] = Route::latest()->get();
        $data['routesArr'] = $this->getRoutes();
        $data['busesArr'] = $this->getBuses();
        $data['buses'] = Bus::latest()->get();
        $data['drivers'] = User::latest()->where('customer_type',3)->get();
        $data['checkers'] = User::latest()->where('customer_type',4)->get();
        $data['helpers'] = User::latest()->where('customer_type',6)->get();

        //dd($data['routes'][1]);
        return view('admin.trip.index',$data);
    }
    public function create(){
        $data['page_title'] = "Trip Create";
        $data['routes'] = Route::latest()->get();
        $data['buses'] = Bus::latest()->get();
        $user = Auth::user();
        if ($user->hasRole('admin')){
            $data['owners'] = User::latest()->where('customer_type',2)->get(); //owner
        }else{
            $data['owners'] = User::latest()->where('customer_type',2)->where('id','=',$user->id)->get(); //owner

        }
        $data['drivers'] = User::latest()->where('customer_type',3)->get();//driver
        $data['checkers'] = User::latest()->where('customer_type',4)->get();//checker
        $data['helpers'] = User::latest()->where('customer_type',6)->get();// helper

        /// admin = 1 , owner = 2 , driver = 3, checker = 4 , customer = 5 , helper = 6

        //dd($data['routes'][1]);
        return view('admin.trip.create',$data);
    }

    public function store( Request $request){

        $valid = $request->validate([
            'start_time' => 'required',
            'route' => 'required',
            'driver_id' => 'required',
            'helper_id' => 'required',
            'checker_id' => 'required',
            'bus_id' => 'required',
            'total_seat' => 'required',
            'owner_id' => 'required'
        ]);

        if(!$valid){
            return response()->json();
        }


        Trip::create([
            'start_time' => Carbon::parse($request->start_time)->format('Y-m-d H:i:s'),
            'end_time' =>  Carbon::parse($request->end_time)->format('Y-m-d H:i:s'),
            'route' => $request->route,
            'driver_id' => $request->driver_id,
            'helper_id' => $request->helper_id,
            'checker_id' => $request->checker_id,
            'bus_id' => $request->bus_id,
            'total_seat' => $request->total_seat,
            'owner_id' => $request->owner_id,
        ]);
        session()->flash('message','Trip Created successfully !!');
        return redirect()->route('trip.index');
    }

    public function edit($id)
    {
        $data['page_title'] = "Trip Edit";
        $data['trip'] = Trip::with('driver','bus','helper','checker')->findOrFail($id);
        $data['buses'] = Bus::where('owner_id',$data['trip']->owner_id)->latest()->get();
        $user = Auth::user();
        if ($user->hasRole('admin')){
            $data['owners'] = User::latest()->where('customer_type',2)->get(); //owner
        }else{
            $data['owners'] = User::latest()->where('customer_type',2)->where('id','=',$user->id)->get(); //owner

        }


        $driver = [];
        $checker = [];
        $helper = [];

        //$employees = UserDetails::where('owner_id',$data['trip']->owner_id)->get();
        // foreach ($employees as $employee){
        //     $em = \App\User::findOrFail($employee->user_id);
        //     if ($em->customer_type == 3){
        //         $driver[] = $em;
        //     }elseif ($em->customer_type == 4){
        //         $checker[] = $em;
        //     }else{
        //         $helper[] = $em;
        //     }
        // }

        $employees = User::all();
        foreach ($employees as $em){
            if ($em->customer_type == 3){
                $driver[] = $em;
            }elseif ($em->customer_type == 4){
                $checker[] = $em;
            }else{
                $helper[] = $em;
            }
        }




        $data['drivers'] = $driver;
        $data['checkers'] = $checker;
        $data['helpers'] = $helper;
        $data['routes'] = Route::latest()->get();
        return view('admin.trip.edit',$data);


    }
    public function update(Request $request){

        $valid = $request->validate([
            'start_time' => 'required',
            'driver_id' => 'required',
            'helper_id' => 'required',
            'checker_id' => 'required',
            'bus_id' => 'required',
            'total_seat' => 'required',
            'owner_id' => 'required'
        ]);

        if(!$valid){
            return response()->json();
        }

        $trip = Trip::findOrFail($request->id);
        $in = $request->all();
        $in['start_time'] = Carbon::parse($request->start_time)->format('Y-m-d H:i:s');
        $in['end_time'] =  Carbon::parse($request->end_time)->format('Y-m-d H:i:s');

        $trip->fill($in)->save();
        session()->flash('message','Trip Update successfully !!');
        return redirect()->route('trip.index');

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
            $busesArr[$bus->coach_number] = $bus->coach_number;
        }

        return $busesArr;
    }
}
