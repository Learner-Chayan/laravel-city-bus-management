@extends('admin.layout.layout')

@section('content')
    @role('admin')




    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="card gradient-1">
                <div class="card-body">
                    <h3 class="card-title text-white">Total Bus</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{$total_bus}}</h2>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-train"></i></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card gradient-2">
                <div class="card-body">
                    <h3 class="card-title text-white">Total Ticket Sale</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{ $total_ticket_sale }} BDT</h2>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card gradient-3">
                <div class="card-body">
                    <h3 class="card-title text-white">Total Route</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{$total_route}}</h2>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card gradient-4">
                <div class="card-body">
                    <h3 class="card-title text-white">Total Owner</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{$total_owner}}</h2>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-user-md"></i></span>
                </div>
            </div>
        </div>
    </div>
    @endrole
{{--    customer panel --}}
    @role('customer')
    <div class="row">
{{--        <div class="col-lg-6 col-md-6 col-sm-6">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <h4 class="card-title">Purchase Ticket</h4>--}}
{{--                    <div class="basic-form">--}}
{{--                        {!! Form::open(['route'=>['sliders.store'],'method'=>'post','files' => true]) !!}--}}
{{--                        <div class="form-group">--}}
{{--                            <label class="text-bold text-uppercase">Select Route</label>--}}
{{--                            <select name="route_id" id="route_id" class="select2" required style="width: 100%">--}}
{{--                                <option value="">Select One</option>--}}
{{--                                @foreach($routes as $route)--}}
{{--                                    <option value="{{$route->id}}">{{$route->name}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group" id="fromStoppage" style="display: none">--}}
{{--                            <label class="text-bold text-uppercase">From</label>--}}
{{--                            <select name="from_id" id="from_id" class="select2" required style="width: 100%">--}}

{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group" id="toStoppage" style="display: none">--}}
{{--                            <label class="text-bold text-uppercase">To</label>--}}
{{--                            <select name="to_id" id="to_id" class="select2" required style="width: 100%">--}}

{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <button type="submit" class="btn btn-dark btn-block icon-paper-plane"> Purchase</button>--}}
{{--                        {!! Form::close() !!}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="col-lg-12 col-md-12 col-sm-12">

        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="card gradient-3">
                <a href="{{route('ticket')}}">
                    <div class="card-body">
                        <h3 class="card-title text-white">Purchase Ticket</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white"></h2>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-ticket"></i></span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="card gradient-1">
                <div class="card-body">
                    <h3 class="card-title text-white">Total Purchase</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">4565</h2>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-train"></i></span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="card gradient-2">
                <div class="card-body">
                    <h3 class="card-title text-white">Total Ticket</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">$ 8541</h2>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span>
                </div>
            </div>
        </div>
    </div>
    @endrole

@endsection
@push('js')
    <script>
        $('#route_id').on('change',function (e){
            let routeId = e.target.value;
            let url = '{{url('/')}}';
            $.get(url + '/stoppage-get?route_id=' + routeId,function (data){
                let formId = $('#from_id').empty();
                let toId = $('#to_id').empty();

                formId.append('<option class="bold" value="">Select One</option>');
                toId.append('<option class="bold" value="">Select One</option>');
                document.getElementById('fromStoppage').style.display = 'block';
                document.getElementById('toStoppage').style.display = 'block';

                $.each(data, function (index,stoppageObj){
                    formId.append('<option value="'+ stoppageObj.id +'">'+ stoppageObj.name +'</option>')
                    toId.append('<option value="'+ stoppageObj.id +'">'+ stoppageObj.name +'</option>')
                })
            })
        })
    </script>
@endpush
