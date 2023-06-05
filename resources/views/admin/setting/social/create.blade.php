@extends('admin.layout.layout')
@section('content')

    <div class="row">
        <div class="col-lg-8 offset-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <div class="basic-form">
                        {!! Form::open(['route'=>['socials.store'],'method'=>'post','files' => true]) !!}
                        <div class="form-group">
                            <label class="text-bold text-uppercase">Socials Title<code>*</code></label>
                            <input type="text" class="form-control"  name="title" value="{{old('title')}}" required placeholder="Socials Title">
                        </div>
                        <div class="form-group">
                            <label class="text-bold text-uppercase">Socials Link<code>*</code></label>
                            <input type="text" class="form-control"  name="link" value="{{old('link')}}" required placeholder="Socials Link">
                        </div>
                        <div class="form-group ">
                            <label class="text-bold text-uppercase">Socials Code<code>*</code></label>
                            <input type="text" class="form-control"  name="code" value="{{old('code')}}" required placeholder="Socials Code">
                        </div>
                        <div class="form-group ">
                            <label class="text-bold text-uppercase">Status</label>
                            <input data-toggle="toggle" checked data-onstyle="success" data-offstyle="danger" data-on="Active" data-off="Deactivate" data-width="100%" type="checkbox" name="status">
                        </div>

                        <button type="submit" class="btn btn-dark btn-block icon-paper-plane"> Socials Create</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

