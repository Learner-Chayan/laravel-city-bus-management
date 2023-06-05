@extends('admin.layout.layout')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <div class="basic-form">
                        {!! Form::open(['route'=>['permissions.update',$permission->id],'method'=>'put','files'=>'true' ]) !!}

                        <div class="form-group">
                            <label class="text-bold text-uppercase">Permission Name<code>*</code></label>
                            <input type="text" class="form-control" name="name" value="{{$permission->name}}" required placeholder="Role Name">
                        </div>
                        <div class="form-group">
                            <strong>Update Assign Role:</strong>
                            <br/>
                            @foreach($roles as $value)
                                <label>{{ Form::checkbox('role[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                    {{ $value->name }}</label>
                                <br/>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-dark btn-block icon-paper-plane"> Permission Update</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

