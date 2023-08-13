@extends('admin.layout.layout')


@section('content')

<style>
:focus{
  outline:none;
}
.radio{
  -webkit-appearance:button;
  -moz-appearance:button;
  appearance:button;
  border:4px solid #ccc;
  border-top-color:#bbb;
  border-left-color:#bbb;
  background:#fff;
  width:30px;
  height:30px;
  border-radius:50%;
}
.radio:checked{
  border:20px solid #4099ff;
}

label{
    border: 1px solid #ddd;
    padding: 10px;
    font-size: 20px;
    width:100%
}
</style>
<div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <h4>

                       <span  style="opacity:0.5"> Trip time : {{ \Carbon\Carbon::parse($trip->start_time)->format('d M , Y H:i a')}} &nbsp;
                        Total seat : {{$trip->total_seat}} &nbsp;
                        Bus : {{$trip->bus->name}} ( {{$trip->bus->coach_number}} ) &nbsp;
                        </span>

                        <a class="btn btn-default" href="{{ route('trip.ticketsList', $trip->id)}}" style="border:1px solid #ddd">
                         <i class="fa fa-eye"></i> View tickets 
                        </a>
                    </h4>


                    <div class="row">
                        <div class="col-6" style="border-right: 2px solid #ddd">
                            <h3>From : </h3>
                            <hr/>
                            <ul>
                                <div class="row">
                                @foreach(json_decode($route->stoppage_id) as $stoppage)

                                    <div class="col-5">
                                       <label for="from{{$stoppage}}" onclick="calculateFare()"><input type="radio" class="radio" name="from" id="from{{$stoppage}}" value="{{$stoppage}}">
                                         {{ $stoppage_details[$stoppage] }} </label >
                                    </div>
                                @endforeach
                                </div>
                            </ul>

                        </div>
                        <div class="col-6">
                            <h3>To : </h3>
                            <hr />

                            <ul>
                                <div class="row">
                                @foreach(json_decode($route->stoppage_id) as $stoppage)

                                    <div class="col-5">
                                       <label for="to{{$stoppage}}" onclick="calculateFare()"><input type="radio" class="radio" name="to" id="to{{$stoppage}}" value="{{$stoppage}}">
                                         {{ $stoppage_details[$stoppage] }} </label>
                                    </div>
                                @endforeach
                                </div>
                            </ul>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-5">
                                   <h3> Is Student ? </h3>
                                </div>
                                <div class="col-2">
                                    <input onclick="calculateFare()" type="checkbox" id="isStudentCheckbox"  class="form-control">
                                </div>
                            </div>

                        </div>
                        <div class="col-6">
                            <h3> <block></block> Fare amount : <span id="fare_amount_show">0</span> BDT </h3>
                        </div>
                    </div>
                    <hr/>
                    <form action="{{route('ticket.confirm')}}" method="POST">
                        <div class="row">
                            <div class="col-4">
                                    @csrf
                                    <input type="hidden" name="totalTicket" id="totalTicket" value="1">
                                    <input type="hidden" name="trip_id" id="trip_id" value="{{ $trip->id }}">
                                    <input type="hidden" name="fare_amount" id="fare_amount">
                                    <input type="hidden" name="from_id" id="from_id">
                                    <input type="hidden" name="to_id" id="to_id">
                                    <input type="hidden" name="payment_by" value="On cash">
                                    <input type="hidden" name="ticketing_by" value="conductor">
                                    <input type="hidden" name="isStudent" id="isStudent"  value="0">
                                    <input type="hidden" name="status" id="isStudent"  value="1">
                                    <!-- Status 1 means ticket confirmed and paid -->
                                    



                            </div>
                            <div class="col-4">
                                <button class="btn btn-success btn-lg" type="submit">Confirm ticket</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>



@endsection

@push('js')
    <script>
        calculateFare();
        function calculateFare(){

            let from = $("input[name=from]:checked").val();
            let to = $("input[name=to]:checked").val();
            let isStudent = $("#isStudentCheckbox").is(":checked");


            let fares = {!!  $fares->price !!} ;
            let route = {!!  $route->id !!} ;
            //console.log(isStudent);

            let fare_amount = fares["fare_"+route+"_"+from+"_"+to];

            if(isStudent){
                $("#fare_amount_show").text(fare_amount ?  fare_amount+" (50%) = "+Math.ceil(fare_amount/2) : 0);
                fare_amount = Math.ceil(fare_amount / 2) ;
                $("#isStudent").val(1);
            }else{
                $("#fare_amount_show").text(fare_amount ? fare_amount : 0);
            }


            //set form values
            $("#fare_amount").val(fare_amount);
            $("#from_id").val(from);
            $("#to_id").val(to);

        }
    </script>
@endpush


