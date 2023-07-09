<?php

namespace App\Http\Controllers;

use App\Models\Stopage;
use App\Models\Route;
use App\Models\Trip;
use App\Models\Fare;
use App\Models\Bus;
use App\Models\Ticket_sale;
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
        $page_title = "Trip List";
        $route_id = $this->getRoute($request->from,$request->to);


        if($route_id){
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
                    $from_id = $request->from;
                    $to_id = $request->to;
                    $from = Stopage::select('name')->where('id',$request->from)->first()->name;
                    $to = Stopage::select('name')->where('id',$request->to)->first()->name;
                    $buses = Bus::all();
                    return view('admin.ticket.trip-search',compact('page_title','trips', 'fare_amount','from',
                    'to','buses','from_id','to_id'));
                }else{
                    return redirect()->back()->with("error",'Fare is not calculated yet !');
                }

            }else{
                return redirect()->back()->with("error",'Trip not found !');
            }
        }else{
            return redirect()->back()->with("error",'Route not found !');
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

    // public function getBusName($id){
    //     $buses = Bus::all();
    //     foreach ($buses as $bus) {
    //         if($bus->id == $id){
    //             return $bus->name;
    //         }
    //     }

    //     return '';
    // }


    public function ticketConfirmation(Request $request){

        $request->validate([
            'totalTicket' => 'required'
        ]);

        $trip = Trip::where('id',$request->trip_id)->first();

        if($trip->total_seat < $request->totalTicket){
            echo "Requested seat is not available !!";
            dd(1);
        }

        $fare_amount_total = $request->totalTicket * $request->fare_amount; 
        $user = auth()->user();

        //create ticket
        $ticket_sales = Ticket_sale::create([
            "issued_by"=> $user->id,
            "trip_id"=> $trip->id,
            "from"=> $request->from_id,
            "to"=> $request->to_id,
            "fare_amount"=> $fare_amount_total,
            "total_seat"=> $request->totalTicket
        ]);


        // now reduce available seat
        $trip->update([
            'total_seat' => $trip->total_seat - $request->totalTicket
        ]);
       
        

        dd($ticket_sales);
        dd($request);
        dd($fare_amount_total);

    }

    public function purchaseHistory(){
        $user = auth()->user();
        $ticket_sales = Ticket_sale::where('issued_by',$user->id)->get();
        $page_title = "Purchase History";

        for($i=0; count($ticket_sales)>$i; $i++) {
            $trip_info = Trip::where('id',$ticket_sales[$i]->trip_id)->first();
            $ticket_sales[$i]->trip_info = $trip_info;

            //stoppage name
            $ticket_sales[$i]->from = Stopage::where('id',$ticket_sales[$i]->from)->first()->name;
            $ticket_sales[$i]->to = Stopage::where('id',$ticket_sales[$i]->to)->first()->name;
        }

        //dd($ticket_sales);

        return view('admin.purchase-history.index',compact('ticket_sales','page_title'));
    }
}
