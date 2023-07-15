@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <form action="{{route('trip-update')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$trip->id}}">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="start_time" class="col-form-label">Start Time:</label>
                                    <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="{{$trip->start_time}}">
                                </div>

                                <div class="form-group">
                                    <label for="end_time" class="col-form-label">End Time:</label>
                                    <input type="datetime-local" class="form-control" id="end_time" name="end_time" value="{{$trip->end_time}}">
                                </div>
                                <div class="form-group">
                                    <label for="route" class="col-form-label">Route:</label>
                                    <select class="form-control select2" style="width: 100%" id="route" name="route">
                                        <option value="">Select One</option>
                                        @foreach($routes as $route)
                                            <option value="{{$route->id}}" {{$route->id == $trip->route ? 'selected' : ''}}>{{$route->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="driver" class="col-form-label">Owner:</label>
                                    <select class="form-control select2" style="width: 100%" id="owner_id" name="owner_id">
                                        <option value="">Select One</option>
                                        @foreach($owners as $owner)
                                            <option value="{{$owner->id}}" {{$owner->id == $trip->owner_id ? 'selected' : ''}}>{{$owner->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="driver" class="col-form-label">Driver:</label>
                                    <select class="form-control select2" style="width: 100%" id="driver_id" name="driver_id">
                                        <option value="">Select One</option>
                                        @foreach($drivers as $driver)
                                            <option value="{{$driver->id}}" {{$driver->id == $trip->driver_id ? 'selected' : ''}}>{{$driver->name}}</option>
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
                                            <option value="{{$helper->id}}" {{$helper->id == $trip->helper_id ? 'selected' : ''}}>{{$helper->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="Contractor" class="col-form-label">Contractor:</label>
                                    <select class="form-control select2" style="width: 100%" id="checker_id" name="checker_id">
                                        <option value="">Select One</option>
                                        @foreach($checkers as $checker)
                                            <option value="{{$checker->id}}" {{$checker->id == $trip->checker_id ? 'selected' : ''}}>{{$checker->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="bus" class="col-form-label">Bus :</label>
                                    <select class="form-control select2" style="width: 100%" id="bus_id" name="bus_id" onchange="busSelected({{ $buses }})">
                                        <option value="">Select One</option>
                                        @foreach($buses as $bus)
                                            <option value="{{$bus->id}}" {{$bus->id == $trip->bus_id ? 'selected' : ''}}>{{$bus->name}}(CN-{{$bus->coach_number}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="total_seat" class="col-form-label">Total Seat:</label>
                                    <input type="text" readonly class="form-control" id="total_seat" name="total_seat" value="{{$trip->bus->seat_number}}">
                                </div>
                                <div class="form-group">
                                    <label for="total_seat" class="col-form-label">Trip Type:</label>
                                    <select class="form-control select2" style="width: 100%" id="trip_type" name="trip_type">
                                        <option value="">Select One</option>
                                        <option value="Up" {{$trip->trip_type == "Up" ? 'selected' : ''}}>Up</option>
                                        <option value="Down" {{$trip->trip_type == "Down" ? 'selected' : ''}}>Down</option>
                                    </select>
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
            let url = "{{url('/')}}";

            $.get(url + '/get-owner-employee?owner_id=' + ownerId,function (data){
                let driver = data.driver;
                let checker = data.checker;
                let helper = data.helper;
                let bus = data.bus;

                $('#driver_id').empty();
                $('#checker_id').empty();
                $('#helper_id').empty();
                $('#bus_id').empty();
                //driver
                $('#driver_id').append('<option value="">Select One</option>')
                $.each(driver,function (index,driverObj){
                    $('#driver_id').append('<option class="bold" value="'+driverObj.id+'">'+driverObj.name+ ' '+driverObj.phone+'</option>')
                });
                //checker
                $('#checker_id').append('<option value="">Select One</option>')
                $.each(checker,function (index,checkerObj){
                    $('#checker_id').append('<option class="bold" value="'+checkerObj.id+'">'+checkerObj.name+ ' '+checkerObj.phone+'</option>')
                });

                //helper
                $('#helper_id').append('<option value="">Select One</option>')
                $.each(helper,function (index,helperObj){
                    $('#helper_id').append('<option class="bold" value="'+helperObj.id+'">'+helperObj.name+ ' '+helperObj.phone+'</option>')
                });

                //bus
                $('#bus_id').append('<option value="">Select One</option>')
                $.each(bus,function (index,busObj){
                    $('#bus_id').append('<option class="bold" value="'+busObj.id+'">'+busObj.name+ ' '+busObj.coach_number+'</option>')
                });
            })
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
    </script>

@endpush
