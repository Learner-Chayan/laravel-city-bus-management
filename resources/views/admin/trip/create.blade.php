@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <form action="{{route('trip.store')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="start_time" class="col-form-label">Start Time:</label>
                                    <input type="datetime-local" class="form-control" id="start_time" name="start_time" >
                                </div>

                                <div class="form-group">
                                    <label for="end_time" class="col-form-label">End Time:</label>
                                    <input type="datetime-local" class="form-control" id="end_time" name="end_time">
                                </div>
                                <div class="form-group">
                                    <label for="route" class="col-form-label">Route:</label>
                                    <select class="form-control select2" style="width: 100%" id="route" name="route">
                                        <option value="">Select One</option>
                                        @foreach($routes as $route)
                                            <option value="{{$route->id}}">{{$route->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="driver" class="col-form-label">Owner:</label>
                                    <select class="form-control select2" style="width: 100%" id="owner_id" name="owner_id">
                                        <option value="">Select One</option>
                                        @foreach($owners as $owner)
                                            <option value="{{$owner->id}}">{{$owner->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="driver" class="col-form-label">Driver:</label>
                                    <select class="form-control select2" style="width: 100%" id="driver_id" name="driver_id">
                                        <option value="">Select One</option>
                                        @foreach($drivers as $driver)
                                            <option value="{{$driver->id}}">{{$driver->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="helper" class="col-form-label">Helper:</label>
                                    <select class="form-control select2" style="width: 100%" id="helper_id" name="helper_id">
                                        <option value="">Select One</option>
                                        @foreach($helpers as $helper)
                                            <option value="{{$helper->id}}">{{$helper->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="Contractor" class="col-form-label">Conductor:</label>
                                    <select class="form-control select2" style="width: 100%" id="checker_id" name="checker_id">
                                    <option value="">Select One</option>
                                        @foreach($checkers as $checker)
                                            <option value="{{$checker->id}}">{{$checker->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="bus" class="col-form-label">Bus :</label>
                                    <select class="form-control select2" style="width: 100%" id="bus_id" name="bus_id" onchange="busSelected({{ $buses }})">

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="total_seat" class="col-form-label">Total Seat:</label>
                                    <input type="text" readonly class="form-control" id="total_seat" name="total_seat">

                                    <p class="text-danger" id="error"></p>
                                    <p class="text-success" id="success"></p>
                                </div>
                                <div class="form-group">
                                    <input name="trip_type" type="hidden" value=" ">
                                </div>
                            </div>
                        </div>

                        <br>
                        <button type="submit" class="btn btn-dark btn-block icon-paper-plane"> Save</button>

                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('js')
    <script>
        $('#owner_id').on('change',function (e){

            let ownerId = e.target.value;
            const buses = {!! $buses !!};

            $('#bus_id').empty();
            $('#bus_id').append('<option value="">Select One</option>')
            for (let i = 0; i < buses.length; i++) {
                const bus = buses[i];
                if(bus.owner_id == ownerId){
                 $('#bus_id').append('<option class="bold" value="'+bus.id+'">'+bus.name+ ' '+bus.coach_number+'</option>');
                }
            }


            //  let ownerId = e.target.value;
            //  let url = "{{url('/')}}";
            //  $('#bus_id').empty();

            //  $.get(url + '/get-owner-employee?owner_id=' + ownerId,function (data){

            //      let bus = data.bus;

            //     $('#bus_id').empty();

            //     //bus
            //     $('#bus_id').append('<option value="">Select One</option>')
            //     $.each(bus,function (index,busObj){
            //         $('#bus_id').append('<option class="bold" value="'+busObj.id+'">'+busObj.name+ ' '+busObj.coach_number+'</option>')
            //     });
            //  })
        });
        function busSelected(buses){
            //console.log(buses);
            let busId = $("#bus_id").val();
            for (let i = 0; i < buses.length; i++) {
                if(buses[i].id == busId){
                    $("#total_seat").val(buses[i].seat_number);
                    break;
                }

            }
        }

        $(function(){
				$('*[name=start_time],[name=end_time]').appendDtpicker({
					amPmInTimeList:true,
                    closeButton:false,
                    todayButton:false,
                    futureOnly:true
				});
			});


    </script>
@endpush
