@extends('admin.layout.layout')


@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header">
                        <h3 class="box-title text-uppercase text-bold">{{$page_title}}</h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <div class="float-right mt-1">
                                <a class="btn bg-fuchsia-active uppercase text-bold" href="{{ route('advertisement') }}"> Back</a>
                            </div>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <!-- form start -->
                        {!! Form::open(['route'=>['advertisement-store'],'method'=>'post','files' => true]) !!}
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs text-bold text-uppercase">
                                            <li class="active"><a href="#tab_1" data-toggle="tab">Own Advertisement</a></li>
                                            <li><a href="#tab_2" data-toggle="tab">Google Advertisement</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1">

                                                {!! Form::open(['route'=>['advertisement-store'],'method'=>'POST','files'=> true]) !!}
                                                <input type="hidden" name="advert_type" value="1">
                                                <div class="form-group">
                                                    <label class="text-bold text-uppercase">Advertisement Size</label>
                                                    <div class="input-group">
                                                        <select name="advert_size" id="advert_size" class="form-control" required>
                                                            <option  value="">Select One</option>
                                                            <option  value="1">300X600</option>
                                                            <option  value="2">300X250</option>
                                                            <option  value="3">728X90</option>
                                                            <option  value="4">970X90</option>
                                                        </select>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-bolt"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-bold text-uppercase">Advertisement Title</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="title" value="" required placeholder="Title">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-bolt"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-bold text-uppercase">Advertisement Link</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="link" value="" required placeholder="Advertisement Link">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-subscript"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <img id='img-upload'/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-bold text-uppercase">Advertisement Image</label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" name="val1" id="imgInp" required >
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-image"></i>
                                                        </div>
                                                    </div>
                                                    <code class="bold">Image Size Must be Equal With Ad Size.</code>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-bold text-uppercase">Status</label>
                                                    <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Show" data-off="Hide" data-width="100%" type="checkbox" name="status">
                                                </div>
                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary btn-lg btn-block text-bold text-uppercase"><span class="fa fa-send"></span> Advertisement Create</button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>

                                            <!-- /.tab-pane -->
                                            <div class="tab-pane" id="tab_2">
                                                {!! Form::open(['route'=>['advertisement-store'],'method'=>'POST','files'=> true]) !!}
                                                <input type="hidden" name="advert_type" value="2">
                                                <div class="form-group">
                                                    <label class="text-bold text-uppercase">Advertisement Size</label>
                                                    <div class="input-group">
                                                        <select name="advert_size" id="advert_size" class="form-control" required>
                                                            <option  value="">Select One</option>
                                                            <option  value="1">300X600</option>
                                                            <option  value="2">300X250</option>
                                                            <option  value="3">728X90</option>
                                                            <option  value="4">970X90</option>
                                                        </select>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-bolt"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-bold text-uppercase">Advertisement Title</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="title" value="" required placeholder="Title">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-bolt"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-bold text-uppercase">Advertisement Code</label>
                                                    <div class="input-group">
                                                        <textarea name="val2" id="" cols="30" rows="5" class="bold form-control input-lg" required placeholder="Advertise Code"></textarea>
                                                        <div class="input-group-addon">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-bold text-uppercase">Status</label>
                                                    <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Show" data-off="Hide" data-width="100%" type="checkbox" name="status">
                                                </div>
                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary btn-lg btn-block text-bold text-uppercase"><span class="fa fa-send"></span> Advertisement Create</button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                        <!-- /.tab-content -->
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col-->
        </div>
        <!-- ./row -->
    </section>
@endsection