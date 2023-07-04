@extends('admin.layout.layout')

@section('content')
    @role('admin')
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="card gradient-1">
                <div class="card-body">
                    <h3 class="card-title text-white">Total Bus</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">4565</h2>
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
                        <h2 class="text-white">$ 8541</h2>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card gradient-3">
                <div class="card-body">
                    <h3 class="card-title text-white">Total Expense</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">4565</h2>
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
                        <h2 class="text-white">99</h2>
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
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Purchase Ticket</h4>
                    <div class="basic-form">
                        {!! Form::open(['route'=>['sliders.store'],'method'=>'post','files' => true]) !!}
                        <div class="form-group">
                            <label class="text-bold text-uppercase">Slider Title</label>
                            <input type="text" class="form-control"  name="title" value="{{old('title')}}" required placeholder="Slider Title">
                        </div>
                        <button type="submit" class="btn btn-dark btn-block icon-paper-plane"> Purchase</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="col-lg-12 col-sm-12">
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
            <div class="col-lg-12 col-sm-12">
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
    </div>
    @endrole

@endsection
