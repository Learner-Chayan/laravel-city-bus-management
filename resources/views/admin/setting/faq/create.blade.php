@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-10 offset-1">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <div class="basic-form">
                        <!-- form start -->
                        {!! Form::open(['route'=>['faqs.store'],'method'=>'post','files' => true]) !!}

                            <div class="form-group">
                                <label class="text-bold text-uppercase">Faq Title</label>
                                <input type="text" class="form-control"  name="title" value="{{old('title')}}" required placeholder="Faq Title">
                            </div>
                            <div class="form-group">
                                <label class="text-bold text-uppercase">Faq Description</label>
                                <textarea name="description" class="summernote"></textarea>
                            </div>
                            <div class="form-group">
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
