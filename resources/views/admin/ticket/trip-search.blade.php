@extends('admin.layout.layout')


@section('content')
<div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <hr/>

                            <div class="row">
                                <div class="col-4">
                                    <h5 class="text-right">
                                        <span id="from">
                                            {{$from}}
                                        </span>
                                    </h5>
                                </div>
                                <div class="col-3"> <p style="border:2px dotted #ddd;margin-top:9px"></p> </div>
                                <div class="col-4">
                                    <h5> <span id="to"> {{$to}} </span> </h5>
                                 </div>
                            </div>
                            <br/>
                            @foreach($trips as $trip)
                            <div class="row border p-4">
                                <div class="clo-6">
                                    <h6> Bus : {{$trip->bus->name}}</i>

{{--                                        @php --}}
{{--                                            foreach($buses as $bus){--}}
{{--                                                if($trip->bus == $bus->id){--}}
{{--                                                    echo $bus->name;--}}
{{--                                                }--}}
{{--                                            }--}}

{{--                                        @endphp--}}
                                    </h6>
                                    <p>Trip Start : {{ \Carbon\Carbon::parse($trip->start_time)->format('d M ,  Y H:i a') }}</p>
                                </div>
                                <div class="col-6">
                                    <h6>Seat available : {{$trip->total_seat}}</h6>
                                    <p>Fare amount : <b> {{$fare_amount}} BDT </b></p>
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#ticketModal" onclick="showTicketModal({{$trip->id}})">Book Now</button>
                                </div>
                            </div>
                            @endforeach
                </div>
            </div>
        </div>
</div>



<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{route('ticket.confirm')}}" method="POST">
{{--            <form action="{{ route('url-create') }}" method="POST">--}}

                @csrf
                <div class="modal-content" >
                    <div class="modal-header bg-orange-active text-center">
                        <h4 class="modal-title" id="myModalLabel2"><i class='fa fa-bus'></i> Ticket Confirmation </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6 text-right">
                                From : <b><span id="show_from"></span></b>
                            </div>
                            <div class="col-6">
                                To : <b> <span id="show_to"></span> </b>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-6">
                                <label for="totalTicket">Total Ticket</label>
                                <select name="totalTicket" id="totalTicket" class="form-control" onchange="calculateFare()">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label >Fare amount (BDT)</label>
                                <input type="text" readonly class="form-control" value="20 BDT" id="fare_amount_calculation">

                                <input type="hidden" value="{{$fare_amount}}" name="fare_amount">
                                <input type="hidden"  name="trip_id" id="trip_id">
                                <input type="hidden"  name="from_id" value="{{$from_id}}">
                                <input type="hidden"  name="to_id" value="{{$to_id}}">
                                <input type="hidden" name="payment_by" value="Pay later">
                                <input type="hidden" name="ticketing_by" value="self">
                                <input type="hidden" name="isStudent" value="0">
                                <input type="hidden" name="status" value="0">
                                <!-- Status 0 means ticket not confirmed and not paid  yet-->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            <button id="confirm_btn" onclick="showLoading()" type="submit" class="btn btn-success "><i class="fa fa-check"></i> CONFIRM</button>
                            <img class="d-none" id="loading_img" src="{{asset('public/assets/admin/loading.gif')}}" width="60" height="60" alt="loading">
                    </div>
                </div>
             </form>
        </div>
    </div>

@endsection

@push('js')
        <script>
            function showTicketModal(trip_id){


                $("#show_from").text($("#from").text());
                $("#show_to").text($("#to").text());
                $("#trip_id").val(trip_id);

                calculateFare();
            }

            function calculateFare(){
                let ticketNum = $("#totalTicket").val();
                $("#fare_amount_calculation").val(ticketNum * <?php echo $fare_amount ?>);
            }

            function showLoading(){
                $("#confirm_btn").hide();
                $("#loading_img").removeClass('d-none');
            }
        </script>
@endpush
