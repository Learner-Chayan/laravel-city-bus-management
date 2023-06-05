@extends('admin.layout.layout')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <a class="btn btn-primary uppercase text-bold float-right" href="{{ route('permissions.index') }}">Permission List</a><br>

                    <div class="basic-form">
                        {!! Form::open(array('route' => 'permissions.store','method'=>'POST')) !!}

                            <div class="form-group">
                                <label class="text-bold text-uppercase">Permission Name<code>*</code></label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required placeholder="Role Name">
                            </div>
                            <div class="form-group">
                                <input type="checkbox" class="form-check-input" name="crud" id="check">
                                <label class="form-check-label" id="check">Check me out for ( *-create *-store *-edit *-update *-destroy )</label>
                            </div>
                            <div class="form-group">
                                <strong>Assign Permission to Role:</strong>
                                <br />
                                @foreach ($roles as $value)
                                    <label>{{ Form::checkbox('role[]', $value->id, false, ['class' => 'name']) }}
                                           {{ $value->name }}</label>
                                    <br />
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-dark btn-block icon-paper-plane"> Permission Create</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

