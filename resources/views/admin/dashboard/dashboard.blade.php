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
    @role('customer|owner|driver|helper|checker')

 <div class="row">
        <!-- <div class="col-lg-3 col-sm-4 ">
            <div class="card gradient-3">
                <a href="{{route('ticket')}}">
                    <div class="card-body ">
                        <h3 class="card-title text-white">Purchase Ticket</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">dfd</h2>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-ticket"></i></span>
                     
                    </div>
                </a>
            </div>
        </div> -->


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
