<?php

namespace App\Http\Controllers;

use App\Models\Stopage;
use App\Models\Route;
use App\Models\Trip;
use App\Models\Fare;
use App\Models\Bus;
use Illuminate\Http\Request;
//use Carbon\Carbon;

class TicketController extends Controller
{

    function __construct(){
        $this->middleware(['Setting']);
    }

    public function index(){
        $stoppages = Stopage::latest()->get();

        $data['page_title'] = "Ticket";
        $data['stoppages'] = $stoppages;

        return view('admin.ticket.index', $data);

    }

    public function searchTrip(Request $request){

        //dd($request);
        $route_id = $this->getRoute($request->from,$request->to);

        if($route_id){
            echo "Route found : ".$route_id;
            //get trip info

            $now = date("Y-m-d H:i:s");
            //dd($now);
            $trips = Trip::where('route',$route_id)
                          ->where('start_time', '>',$now)
                            ->get();
            if(count($trips)){
                //dd($trip);

                //get fare amount
                $fare_amount = $this->getFare($request->from,$request->to,$route_id);
                if($fare_amount){
                    echo $fare_amount;
                    // now show all trips with fare amount 
                    foreach ($trips as $trip ) {
                        echo "<br/>";
                       echo "Start time :".$trip->start_time;
                       echo "<br/>";
                       echo "End Time :".$trip->end_time;
                       echo "<br/>";
                       echo "Bus name :".$this->getBusName($trip->bus);
                       echo "<br/>";
                       echo "available seat :".$trip->total_seat;
                       echo "<br/>";
                       echo "Fare amount :".$fare_amount;
                       echo "<br/>";
                    }
                }else{
                    echo "Fare is not calculated yet";
                }

            }else{
                echo "Trip not found";
            }
        }else{
            echo "Route not found";
        }
    }

    public function getRoute($from,$to){

        $routes = Route::get();
        foreach ($routes as $route ) {
          
            $stoppages = json_decode($route->stoppage_id);
            $from_index = 0; 
            $to_index = 0; 
            for ($i=0;$i<count($stoppages); $i++) {

                if($stoppages[$i] == $from){
                    $from_index = $i+1;;
                }

                if($stoppages[$i] == $to){
                    $to_index = $i+1;
                }
            }

            if($from_index !=0 && $to_index !=0 && $from_index > $to_index){
                return $route->id;
            }
        }

        return null;
    }

    public function getFare($from,$to,$route_id){
        $fares = Fare::where('route_id',$route_id)->first();
        if(!$fares){
            return null;
        }else{
            //get fare amount
            $prices = json_decode($fares->price);
            foreach ($prices as $key=>$value) {
                if($key == 'fare_'.$route_id.'_'.$from.'_'.$to){ //Ex : fare_1_8_6
                    return $value;
                }
            }
        }
        return null;
    }

    public function getBusName($id){
        $buses = Bus::all();
        foreach ($buses as $bus) {
            if($bus->id == $id){
                return $bus->name;
            }
        }

        return '';
    }
}
