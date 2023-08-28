@extends('admin.layout.layout')
@section('content')

    <div class="row">
        <div class="col-lg-8 offset-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <div class="basic-form">
                        {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="text-uppercase">First Name<code>*</code></label>
                                <input type="text" class="form-control" name="name" value="{{$user->name}}" placeholder="First Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-uppercase">Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="{{$user->last_name}}" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-bold text-uppercase">User Phone<code>*</code></label>
                            <input type="text" class="form-control" name="phone" value="{{$user->phone}}" placeholder="User Phone">
                        <div class="form-group">
                            <label class="text-bold text-uppercase">User Email<code>*</code></label>
                            <input type="email" class="form-control" name="email" value="{{$user->email}}" placeholder="User Email">
                        </div>
                        <div class="form-group">
                            <label class="text-bold text-uppercase">Password<code>*</code></label>
                            <input type="text" class="form-control" name="password" value="{{$user->temp_password}}" required placeholder="Your Password">
                        </div>
                        <div class="form-group">
                            <label class="text-bold text-uppercase">Assign Role</label>
                            <select name="roles" class="form-control select2" required data-placeholder="Select a Role" >
                                @foreach($roles as $role)
                                    @if($role->name !='helper' && $role->name !='driver' && $role->name !='checker')
                                    <option value="{{$role->id}}" {{ $user->roles()->pluck('name')->implode(' , ') == $role->name ? 'selected' : '' }}>{!! $role->name !!}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark btn-block icon-paper-plane"> User Update</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

