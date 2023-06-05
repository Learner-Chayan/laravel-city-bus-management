@extends('layouts.app')

@section('content')
    <h3 class="text-center text-uppercase" style="color:indianred;font-family: 'Droid Serif';">{{$page_title}}</h3>
    <form class="" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}
        <input type="hidden" name="student_status" value="1">
        <div class="form-group has-feedback">
            <input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback ">
            <input id="text" type="text" class="form-control" name="phone" placeholder="Phone" value="{{ old('phone') }}" required>
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input id="password" type="password" class="form-control" name="password" placeholder=" Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat" style="font-size: 22px; font-family: 'Fira Code'">Sing Up</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
@endsection
