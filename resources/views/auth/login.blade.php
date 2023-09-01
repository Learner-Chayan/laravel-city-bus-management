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
                <input type="email" class="form-control" name="email" id="email" required placeholder="Enter Your Email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" required placeholder="Enter Your Password">
            </div>
            <button type="submit" class="btn login-form__btn submit w-100">Sign In</button>
        </form>
        <p class="mt-5 login-form__footer">
            
             <h4><a href="{{route('password.request')}}" class="text-primary">Forgot Password ?</a>
            @if(env('REGISTRATION_STATUS'))
             <a href="{{route('register')}}" class="text-primary float-right">Customer Registration</a>
            @endif
        
            </h4>
        </p>

        <div>
            <button type="button" class="btn btn-primary btn-sm" onclick="fillLoginForm('admin@gmail.com','12345678')">Admin</button>
            <button type="button" class="btn btn-info btn-sm" onclick="fillLoginForm('owner@gmail.com','12345678')">Owner</button>
            <button type="button" class="btn btn-success btn-sm" onclick="fillLoginForm('customer@gmail.com','12345678')">Customer</button>
            <button type="button" class="btn btn-danger btn-sm" onclick="fillLoginForm('checker@gmail.com','12345678')">Checker</button>
        </div>
    </div>
@endsection



<script>
fillLoginForm();

    function fillLoginForm(email,password){
        console.log('sdf');
        document.getElementById("email").value = email;
        document.getElementById("password").value = password;
    }


</script>

