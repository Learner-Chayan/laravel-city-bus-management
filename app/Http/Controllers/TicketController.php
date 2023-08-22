<?php

namespace App\Http\Controllers;

use App\Models\Stopage;
use App\Models\Route;
use App\Models\Trip;
use App\Models\Fare;
use App\Models\Bus;
use App\Models\UserDetails;
use App\Models\Ticket_sale;
use Illuminate\Http\Request;
use App\User;
use PDF;
use DB;

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
            'totalTicket' => 'required',
            'from_id' => 'required',
            'to_id' => 'required'
        ]);

        $trip = Trip::where('id',$request->trip_id)->first();

        if($trip->total_seat < $request->totalTicket){
            //echo "Requested seat is not available !!";
            return redirect()->back()->with("error",'Requested seat is not available !!');
        }

        $fare_amount_total = $request->totalTicket * $request->fare_amount;
        $user = auth()->user();

        
        $bus = Bus::findOrFail($trip->bus_id);

        // make unique ticket serial number
        $serial = substr(md5(time()), 0, 10);

        //check who cutting the ticket

        //create ticket
        $ticket = Ticket_sale::create([
            "serial"=> $serial,
            "issued_by"=> $user->id,
            "trip_id"=> $trip->id,
            "from"=> $request->from_id,
            "to"=> $request->to_id,
            "fare_amount"=> $fare_amount_total,
            "total_seat"=> $request->totalTicket,
            "payment_by"=> $request->payment_by,
            "isStudent"=> $request->isStudent,
            "status"=> $request->status,
        ]);


        // now reduce available seat
        $trip->update([
            'total_seat' => $trip->total_seat - $request->totalTicket
        ]);

        $ticket_sales = Ticket_sale::findOrFail($ticket->id);

        $trip_info = Trip::where('id',$ticket_sales->trip_id)->first();
        $ticket_sales->trip_info = $trip_info;

        $ticket_sales->from = Stopage::where('id',$ticket_sales->from)->first()->name;
        $ticket_sales->to   = Stopage::where('id',$ticket_sales->to)->first()->name;
        $ticket_sales->bus  = Bus::where('id',$trip_info->bus_id)->first();



        if($request->ticketing_by == "self"){
            //go to bkash option
            return redirect()->route('url-create',['fare_amount' => $fare_amount_total, 'ticket_id'=>$ticket->id]);
        }else{
            return $this->returnTicket($ticket,$ticket_sales);
        }
        //return redirect('admin/purchase-history')->with('success', 'Your ticket purchased successfully!!');

    }

    public function returnTicket($ticket,$ticket_sales){
        $data = [
            'title' => "Ticket-".$ticket->serial,
            'date' => date('m/d/Y'),
            'ticket' => $ticket_sales,
            'issued_by' => auth()->user()->name,
        ];
        $pdf = PDF::loadView('admin.ticket.ticket', $data)->setPaper('A7', 'landscape');
        return $pdf->download('Ticket-'.$ticket_sales->serial.'.pdf');
    }

    public function purchaseHistory(){
        $user = auth()->user();
        $ticket_sales = Ticket_sale::where('issued_by',$user->id)->orderBy('id','DESC')->get();
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

        $issued_by = '';
        if($expected_user = DB::table('users')->where('id',$ticket_sales->issued_by)->first()){
            $issued_by = $expected_user->name;
        }

        $data = [
            'title' => "Ticket-".$ticket_sales->serial,
            'date' => date('m/d/Y'),
            'ticket' => $ticket_sales,
            'issued_by' => $issued_by,
        ];

        $pdf = PDF::loadView('admin.ticket.ticket', $data)->setPaper('A7', 'landscape');

        return $pdf->download('Ticket-'.$ticket_sales->serial.'.pdf');
    }



    public function ticketOptions($trip_id){


        if($trip_id < 1 || !is_numeric($trip_id)){
            return view('404');
        }

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

        if(!$fares){
            return redirect()->back()->with('error','Fare is not calculated yet !!');
        }

        return view('admin.serve-ticket.index', $data);
    }


    public  function  ticketValidation(){
        $data['page_title'] = "Validate Ticket";
        return view('admin.ticket-validation.index',$data);
    }

    public function  checkTicket(Request $request){
        $request->validate([
            'ticketNumber' => 'required'
        ]);


        $ticket_sales = Ticket_sale::where('serial', $request->ticketNumber)->first();
        if($ticket_sales) {

            $trip_info = Trip::where('id', $ticket_sales->trip_id)->first();
            $ticket_sales->trip_info = $trip_info;

            $ticket_sales->from = Stopage::where('id', $ticket_sales->from)->first()->name;
            $ticket_sales->to = Stopage::where('id', $ticket_sales->to)->first()->name;

            $ticket_sales->bus = Bus::where('id', $trip_info->bus_id)->first();

            $issued_by = '';
            if ($expected_user = DB::table('users')->where('id', $ticket_sales->issued_by)->first()) {
                $issued_by = $expected_user->name;
            }

            $data = [
                'page_title' => 'Validate Ticket',
                'title' => "Ticket-" . $ticket_sales->serial,
                'date' => date('m/d/Y'),
                'ticket' => $ticket_sales,
                'issued_by' => $issued_by,
                'isTicketFound' => true,
            ];


            return view('admin.ticket-validation.index',$data);
        }else{
            return redirect()->back()->with('error', 'Ticket not found');
        }
    }


    //trip tickets 
    public function showTripTickets($trip_id){
       

        if($trip_id < 1 || !is_numeric($trip_id)){
            return view('404');
        }

        $ticket_sales = Ticket_sale::where('trip_id',$trip_id)->orderBy('id','DESC')->get();
        $page_title = "Tickets List";

        for($i=0; count($ticket_sales)>$i; $i++) {
            //$trip_info = Trip::where('id',$ticket_sales[$i]->trip_id)->first();
            //$ticket_sales[$i]->trip_info = $trip_info;

            //stoppage name
            $ticket_sales[$i]->from = Stopage::where('id',$ticket_sales[$i]->from)->first()->name;
            $ticket_sales[$i]->to = Stopage::where('id',$ticket_sales[$i]->to)->first()->name;
            $ticket_sales[$i]->issued_by = User::where('id',$ticket_sales[$i]->issued_by)->first()->name;
        }

        return view('admin.serve-ticket.tickets-list',compact('ticket_sales','page_title', 'trip_id'));
    }

    public function ticketStatusUpdate($ticket_id){
        
        $ticket = Ticket_sale::findOrFail($ticket_id);
        $ticket->update([
            'status' => 1,
            'payment_by' => 'On cash'
        ]);

        return redirect()->back()->with('message', 'Ticket confirmed successfully !!');
    }
}
