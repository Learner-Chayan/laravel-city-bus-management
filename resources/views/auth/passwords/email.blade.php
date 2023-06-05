@extends('layouts.app')

@section('content')
    <h3 class="text-uppercase text-center" style="font-family: 'Fira Code'">{{$page_title}}</h3>
    <form class="form-horizontal" method="POST" action="{{ route('forget.password.post') }}">
        {{ csrf_field() }}
        <div class="col-md-12">
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="input-group">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Please Enter Your Email">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-block text-uppercase">
                    Reset Password
                </button>
            </div>
        </div>
    </form>
@endsection

