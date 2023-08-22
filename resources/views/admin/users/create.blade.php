@extends('admin.layout.layout')
@section('content')

    <div class="row">
        <div class="col-lg-8 offset-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <div class="basic-form">
                        {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="text-uppercase">First Name<code>*</code></label>
                                <input type="text" class="form-control" name="first_name" value="{{old('name')}}" placeholder="First Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-uppercase">Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="{{old('last_name')}}" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-bold text-uppercase">User Phone<code>*</code></label>
                            <input type="text" class="form-control" name="phone" value="{{old('phone')}}" required placeholder="User Phone">
                        </div>
                        <div class="form-group">
                            <label class="text-bold text-uppercase">User Email<code>*</code></label>
                            <input type="email" class="form-control" name="email" value="{{old('email')}}" required placeholder="User Email">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="text-bold text-uppercase">Password<code>*</code></label>
                                <input type="password" class="form-control" name="password" required placeholder="Your Password">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-bold text-uppercase">Confirm Password<code>*</code></label>
                                <input type="password" class="form-control" name="confirm-password" required placeholder="Confirm Your Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-bold text-uppercase">Assign Role</label>
                            <select name="roles" class="form-control select2" required data-placeholder="Select a Role" >
                                <option value="">Select One</option>
                                @foreach($roles as $role)
                                    @if($role->name !='helper' && $role->name !='driver' && $role->name !='checker')
                                        <option>{!! $role->name !!}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark btn-block icon-paper-plane"> User Create</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

