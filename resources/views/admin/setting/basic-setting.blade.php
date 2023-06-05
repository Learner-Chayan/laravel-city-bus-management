@extends('admin.layout.layout')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <div class="basic-form">
                        {!! Form::open(['route'=>['get-basic-update'],'method'=>'POST','files'=>'true' ]) !!}
                        <div class="basic-list-group">
                            <div class="row">

                                <div class="col-xl-8 col-md-8 col-sm-9">
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="list-home">
                                            <div class="form-group">
                                                <label class="text-uppercase text-bold">Website Title</label>
                                                <input type="text" class="form-control" name="title" value="{{$basic->title}}"  placeholder="Website Title">
                                            </div>
                                            <div class="form-group">
                                                <label class="text-uppercase text-bold">Website Email</label>
                                                <input type="email" class="form-control" name="email" value="{{$basic->email}}"  placeholder="Website Email">
                                            </div>
                                            <div class="form-group">
                                                <label class="text-uppercase text-bold">Website Phone</label>
                                                <input type="text" class="form-control" name="phone" value="{{$basic->phone}}"  placeholder="Website Phone">
                                            </div>
                                            <div class="form-group">
                                                <label class="text-uppercase text-bold">Website Address</label>
                                                <input type="text" class="form-control" name="address" value="{{$basic->address}}"  placeholder="Website Address">
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="list-profile" role="tabpanel">
                                            <div class="form-group" style="margin-left: 250px">
                                                <div class="input-group">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 215px; height: 215px; padding: 0px;" data-trigger="fileinput">
                                                            <img style="width: 215px" src="{{asset('public/logo.png') }}" alt="Please Select Your Image......">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 215px; max-height: 215px"></div>
                                                        <div>
                                                            <span class="btn btn-info btn-file">
                                                                <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select Logo</span>
                                                                <span class="fileinput-exists bold uppercase"><i class="fa fa-edit"></i> Change</span>
                                                                <input type="file" name="logo" accept="image/*">
                                                            </span>
                                                            <a href="#" class="btn btn-danger fileinput-exists bold uppercase" data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="list-messages">
                                            <div class="form-group" style="margin-left: 250px">
                                                <div class="input-group">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 215px; height: 215px; padding: 0px;" data-trigger="fileinput">
                                                            <img style="width: 215px" src="{{asset('public/favicon.png') }}" alt="Please Select Your Image......">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 215px; max-height: 215px"></div>
                                                        <div>
                                                            <span class="btn btn-info btn-file">
                                                                <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select Favicon Image</span>
                                                                <span class="fileinput-exists bold uppercase"><i class="fa fa-edit"></i> Change</span>
                                                                <input type="file" name="favicon" accept="image/*">
                                                            </span>
                                                            <a href="#" class="btn btn-danger fileinput-exists bold uppercase" data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="list-settings">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-4 col-sm-3 mb-4 mb-sm-0 mt-4">
                                    <div class="list-group" id="list-tab" role="tablist">
                                        <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Website Basic</a>
                                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Website Logo</a>
                                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages">Website Favicon</a>
{{--                                        <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">Settings</a>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-dark btn-block icon-paper-plane"> Update</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


