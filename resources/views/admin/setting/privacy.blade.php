@extends('admin.layout.layout')
@section('content')

    <div class="row">
        <div class="col-lg-10 offset-1">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <div class="basic-form">
                        {!! Form::open(['route'=>['get-privacy-update'],'method'=>'POST','files'=>'true' ]) !!}
                        <div class="form-group ">
                            <textarea class="summernote" style="height: 100px; " name="privacy">{!! $basic->privacy !!}</textarea>
                        </div>
                        <button type="submit" class="btn btn-dark btn-block icon-paper-plane"> Update</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
