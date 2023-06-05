@extends('admin.layout.layout')
@section('content')

    <div class="row">
        <div class="col-lg-8 offset-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <div class="basic-form">
                        {!! Form::open(['route'=>['change-password'],'method'=>'POST','files'=>'true' ]) !!}
                            <div class="form-group">
                                <label class="text-uppercase text-bold">Old Password<code>*</code></label>
                                <input type="password" class="form-control" name="old_password" required placeholder="Enter Your Old Password">
                            </div>
                            <div class="form-group">
                                <label class="text-uppercase text-bold">New Password<code>*</code></label>
                                <input type="password" class="form-control" name="password" required placeholder="Enter New Password">
                            </div>
                            <div class="form-group">
                                <label class="text-uppercase text-bold">Confirm Password<code>*</code></label>
                                <input type="password" class="form-control" name="confirm-password" required placeholder="Enter Confirm Password">
                            </div>
                            <button type="submit" class="btn btn-dark btn-block icon-paper-plane "> Update Password</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

