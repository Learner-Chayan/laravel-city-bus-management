@extends('layouts.app')

@section('content')
    @php $page_title = "Reset Password" @endphp
    <h3 class="text-uppercase text-center" style="font-family: 'Fira Code'">{{$page_title}}</h3>
    <form class="form-horizontal" method="POST" action="{{ route('reset.password.post') }}" style="padding: 33px">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="col-md-12">
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="text-bold text-uppercase">E-Mail Address</label>
                <div class="input-group">
                    <input id="email" type="email" class="form-control" name="email" value="{{old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="text-bold text-uppercase">Password</label>
                <div class="input-group">
                    <input id="password" type="password" class="form-control" name="password" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label class="text-bold text-uppercase">Confirm Password</label>
                <div class="input-group">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
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
