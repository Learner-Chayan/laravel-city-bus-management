@extends('layouts.app')

@section('content')
    @if(env('SOCIAL_LOGIN'))
        <div class="social-auth-links text-center">
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                Facebook</a>
            <a href="{{ url('auth/google') }}" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                Google+</a>
        </div>
    @endif
    <div class="card-body pt-5">
        <a class="text-center text-uppercase" href="#"> <h4>{{$site_title}}</h4></a>

        <form class="mt-5 mb-5 login-input" action="{{ route('login') }}" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <input type="email" class="form-control" name="email" required placeholder="Enter Your Email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" required placeholder="Enter Your Password">
            </div>
            <button type="submit" class="btn login-form__btn submit w-100">Sign In</button>
        </form>
        <p class="mt-5 login-form__footer">
            @if(env('REGISTRATION_STATUS'))
                Dont have account? <a href="{{route('register')}}" class="text-primary">Sign Up</a> now
            @endif
            &nbsp;  <a href="{{route('password.request')}}" class="text-primary">Forgot Password ?</a> </p>
    </div>
@endsection
