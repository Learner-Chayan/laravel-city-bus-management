<?php

namespace App\Http\Controllers;

use App\Models\Stopage;
use App\Models\Route;
use App\Models\Trip;
use App\Models\Fare;
use App\Models\Bus;
use App\Models\Ticket_sale;
use Illuminate\Http\Request;
use PDF;

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
//        dd($route_id);

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
//            return $stoppages;
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
            //echo "Requested seat is not available !!";
            return redirect()->back()->with("error",'Requested seat is not available !!');
        }

        $fare_amount_total = $request->totalTicket * $request->fare_amount;
        $user = auth()->user();

        // make unique ticket serial number
        $bus = Bus::findOrFail($trip->bus_id);
        $ticketId = Ticket_sale::latest()->first();
        if ($ticketId)
        {
            $serial = date('dmY').$bus->id.$ticketId->id;
        }
        else{
            $tId = 1;
            $serial = date('dmY').$bus->id.$tId;
        }

        //create ticket
        $ticket = Ticket_sale::create([
            "serial"=> $serial,
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

        $ticket_sales = Ticket_sale::findOrFail($ticket->id);

        $trip_info = Trip::where('id',$ticket_sales->trip_id)->first();
        $ticket_sales->trip_info = $trip_info;

        $ticket_sales->from = Stopage::where('id',$ticket_sales->from)->first()->name;
        $ticket_sales->to = Stopage::where('id',$ticket_sales->to)->first()->name;

        $ticket_sales->bus = Bus::where('id',$trip_info->bus_id)->first();

        $data = [
            'title' => "Ticket-".$ticket->serial,
            'date' => date('m/d/Y'),
            'ticket' => $ticket_sales
        ];


        $pdf = PDF::loadView('admin.ticket.ticket', $data)->setPaper('A7', 'landscape');

         $pdf->stream('Ticket-'.$ticket_sales->serial.'.pdf');

        return redirect('admin/purchase-history')->with('success', 'Your ticket purchased successfully!!');

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

        return view('admin.purchase-history.index',compact('ticket_sales','page_title'));
    }

    public function ticketPdf($id)
    {

        $ticket_sales = Ticket_sale::findOrFail($id);

        $trip_info = Trip::where('id',$ticket_sales->trip_id)->first();
        $ticket_sales->trip_info = $trip_info;

        $ticket_sales->from = Stopage::where('id',$ticket_sales->from)->first()->name;
        $ticket_sales->to = Stopage::where('id',$ticket_sales->to)->first()->name;

        $ticket_sales->bus = Bus::where('id',$trip_info->bus_id)->first();

        $data = [
            'title' => "Ticket-".$ticket_sales->serial,
            'date' => date('m/d/Y'),
            'ticket' => $ticket_sales
        ];

        $pdf = PDF::loadView('admin.ticket.ticket', $data)->setPaper('A7', 'landscape');

        return $pdf->download('Ticket-'.$ticket_sales->serial.'.pdf');
    }



    public function ticketOptions($trip_id){

        $trip = Trip::findOrFail($trip_id);
        $stoppages = Stopage::latest()->get();
        $route = Route::findOrFail($trip->route);
        $fares = Fare::where('route_id',$route->id)->first();
        //dd($trip);

        $stoppage_details = [];
        foreach($stoppages as $stoppage){
            $stoppage_details[$stoppage->id] = $stoppage->name;
        }

        $data['page_title'] = "Serve Ticket";
        $data['trip'] = $trip;
        $data['fares'] = $fares;
        $data['route'] = $route;
        $data['stoppage_details'] = $stoppage_details;

        return view('admin.serve-ticket.index', $data);
    }


    public  function  createPayment(){

    }
}
