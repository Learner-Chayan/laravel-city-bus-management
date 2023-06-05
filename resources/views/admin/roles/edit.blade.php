@extends('admin.layout.layout')
@section('content')

    <div class="row">
        <div class="col-lg-8 offset-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <div class="basic-form">
                        {!! Form::open(['route'=>['roles.update',$role->id],'method'=>'put','files'=>'true' ]) !!}

                        <div class="form-group">
                            <label class="text-bold text-uppercase">Role Name<code>*</code></label>
                            <input type="text" class="form-control" name="name" value="{{$role->name}}" required placeholder="User Name">
                        </div>
                        <div class="form-group">
                            <label class="text-bold text-uppercase">Assign Role</label><br>
                            @foreach($permission as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                    {{ $value->name }}</label>
                                <br/>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-dark btn-block icon-paper-plane"> Role Update</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

