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
                    <p>

                        Trip time : {{$trip->start_time}} &nbsp;
                        Total seat : {{$trip->total_seat}} &nbsp;
                        Bus : {{$trip->bus->name}} ( {{$trip->bus->coach_number}} ) &nbsp;
                    </p>


                    <div class="row">
                        <div class="col-6" style="border-right: 2px solid #ddd">
                            <h3>From : </h3>
                            <hr/>
                            <ul>
                                <div class="row">
                                @foreach(json_decode($route->stoppage_id) as $stoppage)

                                    <div class="col-5">
                                       <label><input type="radio" class="radio" name="from" id="from{{$stoppage}}">
                                         {{ $stoppage_details[$stoppage] }} </label for="from{{$stoppage}}">
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
                                       <label><input type="radio" class="radio" name="to" id="to{{$stoppage}}">
                                         {{ $stoppage_details[$stoppage] }} </label for="to{{$stoppage}}">
                                    </div>
                                @endforeach
                                </div>
                            </ul>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-12">
                             <h3>Fare amount : 20 BDT </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>



@endsection


