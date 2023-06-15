<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Stopage;
use App\Models\Fare;

class FareController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','Setting']);
    }

    public function index(Request $request){

      $routes =   Route::latest()->get(['id','name']);
      $data['page_title'] = "Route List";
      $data['routes'] =$routes;
      $data["selected_route"] = null;

      if(isset($request->route)){

          $id = htmlspecialchars($request->route);
          $selected_route = Route::find($id);
          $data['selected_route'] = $selected_route;

          //get stoppages
          $stoppages = Stopage::all();
          $stoppages_arr = [];
          $price_arr = [];
          foreach ($stoppages as $stoppage){
              $stoppages_arr[$stoppage->id] = $stoppage->name;
          }

          // get pricing
          $fare = Fare::where('route_id',$id)->first();
          if($fare){
              $prices = json_decode($fare->price);
              foreach ($prices as $key=>$price){
                 $price_arr[$key] = $price;
              }
          }


          $data["stoppages_arr"] =$stoppages_arr;
          $data["price_arr"] = $price_arr;


      }

      return view('admin.fare.index',$data);
    }

    public function pricing(Request $request){


        $data = json_encode($request->except(['route_id','_token']));

        $isExist = Fare::where('route_id',$request->route_id)->first();

        if($isExist){
            $fare = Fare::findOrFail($isExist->id);
            $fare->price = $data;
            $fare->save();
        }else{
            $fare = new Fare();
            $fare->route_id = $request->route_id;
            $fare->price = $data;
            $fare->save();
        }


        return redirect()->back()->with('message','Fare updated successfully');
    }
}
