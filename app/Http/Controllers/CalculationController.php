<?php

namespace App\Http\Controllers;

use App\Models\Stopage;
use App\Models\Route;
use App\Models\Trip;
use App\Models\Fare;
use App\Models\Bus;
use App\Models\UserDetails;
use App\Models\Ticket_sale;
use App\User;

use Illuminate\Http\Request;

class CalculationController extends Controller
{
    

    function __construct(){
        $this->middleware(['Setting']);
    }


    public function showTripReceipts($trip_id){
       

        if($trip_id < 1 || !is_numeric($trip_id)){
            return view('404');
        }

        $ticket_sales = Ticket_sale::where('trip_id',$trip_id)->where('status',1)->orderBy('id','DESC')->get();
        //status = 1 means paid tickets

        $trip_info = Trip::with('bus','driver','helper','checker')->where('id',$trip_id)->first();
        $route_info = Route::where('id',$trip_info->route)->first();


        //dd($route_info);


        $page_title = "Receipts List";

        $total_amount = 0 ;
        $total_tickets = count($ticket_sales); 
        for($i=0; count($ticket_sales)>$i; $i++) {
            //$trip_info = Trip::where('id',$ticket_sales[$i]->trip_id)->first();
           // $ticket_sales[$i]->trip_info = $trip_info;

            //stoppage name
            $ticket_sales[$i]->from = Stopage::where('id',$ticket_sales[$i]->from)->first()->name;
            $ticket_sales[$i]->to = Stopage::where('id',$ticket_sales[$i]->to)->first()->name;
            $ticket_sales[$i]->issued_by = User::where('id',$ticket_sales[$i]->issued_by)->first()->name;

            $total_amount += $ticket_sales[$i]->fare_amount;
        }

        return view('admin.calculation.index',compact('ticket_sales','page_title', 'trip_id', 'total_amount', 'total_tickets','trip_info','route_info'));
    }
}
