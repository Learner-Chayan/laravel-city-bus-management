@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <hr/>
                    <form method="POST" action="{{ route('ticket.check') }}">
                        <div class="row">
                                <div class="col-4">
                                        @csrf
                                        <div class="form-group">
                                            <label> Enter Ticket Number</label>
                                            <input type="text" class="form-control" placeholder="Enter Ticket Number" name="ticketNumber">
                                            <br/>

                                        </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mt-2">
                                        <br/>
                                        <button type="submit" class="btn btn-default btn-lg"> Check </button>
                                    </div>
                                </div>
                        </div>
                    </form>
                    <div  class="row">
                        <div class="col-6">
                            @if(isset($isTicketFound))
                                <h4>Ticket Number : {{ $ticket->serial }}</h4>
                                <hr/>
                                <h6> Journey Date : <b> {{\Carbon\Carbon::parse($ticket->trip_info->start_time)->format('d M,Y H:i a') }} </b></h6>
                                <h6> Bus Name : <b> {{$ticket->bus->name}} ({{$ticket->bus->coach_number}})</b> </h6>
                                <h6> Issued by : <b> {{$issued_by}}</b> </h6>
                                <h6> Form : <b> {{$ticket->from}}</b> </h6>
                                <h6> To : <b> {{$ticket->to}}</b> </h6>
                                <h6> Total seat : <b> {{$ticket->total_seat}}</b> </h6>
                                <h6> Fare : <b> {{$ticket->fare_amount}} BDT ({{$ticket->payment_by}})</b> </h6>
                                @if($ticket->isStudent)
                                    <p> Passenger type : Student</p>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
