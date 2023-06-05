@extends('admin.layout.layout')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <div class="basic-form">
                        {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}

                            <div class="form-group">
                                <label class="text-bold text-uppercase">Role Name<code>*</code></label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required placeholder="User Name">
                            </div>
                            <div class="form-group">
                                <label class="text-bold text-uppercase">Assign Role<code>*</code></label>
                                <select name="permission[]" class="form-control select2" multiple="multiple" required data-placeholder="Select a Role" >
                                    @foreach($permission as $value)
                                        <option value="{{$value->id}}"> {{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <strong>Permission List:</strong>--}}
{{--                                <br/>--}}
{{--                                @foreach($permission as $value)--}}
{{--                                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}--}}
{{--                                        {{ $value->name }}</label>--}}
{{--                                    <br/>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
                            <button type="submit" class="btn btn-dark btn-block icon-paper-plane"> Role Create</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

