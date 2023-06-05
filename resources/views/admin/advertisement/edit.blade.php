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
                        {!! Form::open(['route'=>['advertisement-update'],'method'=>'post','files' => true]) !!}
                        <input type="hidden" name="id" value="{{$advert->id}}">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="form-group">
                                    <label>Advertise Size</label>
                                    <div class="input-group">
                                        <select name="advert_size" id="" class="form-control " required>
                                            @if($advert->advert_size == 1)
                                                <option  value="1" selected>300X600</option>
                                                <option  value="2">300X250</option>
                                                <option  value="3">728X90</option>
                                                <option  value="4">970X90</option>
                                                {{--<option  value="5">970X250</option>--}}
                                            @elseif($advert->advert_size == 2)
                                                {{--<option  value="1">300X600</option>--}}
                                                <option  value="2" selected>300X250</option>
                                                <option  value="3">728X90</option>
                                                <option  value="4">970X90</option>
                                                {{--<option  value="5">970X250</option>--}}
                                            @elseif($advert->advert_size == 3)
                                                {{--<option  value="1">300X600</option>--}}
                                                <option  value="2">300X250</option>
                                                <option  value="3" selected>728X90</option>
                                                <option  value="4">970X90</option>
                                                {{--<option  value="5">970X250</option>--}}
                                            @elseif($advert->advert_size == 4)
                                                {{--<option  value="1">300X600</option>--}}
                                                <option  value="2">300X250</option>
                                                <option  value="3">728X90</option>
                                                <option  value="4" selected>970X90</option>
                                                {{--<option  value="5">970X250</option>--}}
                                            @endif
                                        </select>
                                        <span class="input-group-addon"><strong><i class="fa fa-list"></i></strong></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label >Advertise Title</label>
                                    <div class="input-group">
                                        <input class="form-control bold input-lg" name="title" value="{{ $advert->title }}" type="text" placeholder="Advertisement Title" required>
                                        <span class="input-group-addon"><strong><i class="fa fa-file-text-o"></i></strong></span>
                                    </div>
                                </div>
                                @if($advert->advert_type == 1)
                                    <div class="form-group">
                                        <label>Advertise Link</label>
                                        <div class="input-group">
                                            <input class="form-control bold input-lg" name="link" value="{{ $advert->link }}" type="text" placeholder="Advertisement Link" required>
                                            <span class="input-group-addon"><strong><i class="fa fa-bolt"></i></strong></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="l">Advertisement Image</label>
                                        <div class="input-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: auto; height: auto; padding: 0px;" data-trigger="fileinput">
                                                    <img style="width: auto ; height: auto " src="{{asset('public/images/ad')}}/{{$advert->val1}}" alt="Select Image">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="width: auto; max-height: 215px"></div>

                                                <div>
                                                        <span class="btn btn-info btn-file">
                                                            <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select image</span>
                                                            <span class="fileinput-exists bold uppercase"><i class="fa fa-edit"></i> Change</span>
                                                            <input type="file" name="val1" accept="image/*">
                                                        </span>
                                                    <a href="#" class="btn btn-danger fileinput-exists bold uppercase" data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                                </div>
                                                <code >Image Size Must be Equal With Ad Size.</code>

                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label>Advertise Code</label>
                                        <textarea name="val2" id="" cols="30" rows="8" class="bold form-control input-lg" required placeholder="Advertise Code">{{ $advert->val2 }}</textarea>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="l">Status</label>
                                    <input data-toggle="toggle" data-onstyle="success" {{ $advert->status == 1 ? 'checked' : ''}} data-offstyle="danger" data-on="Show" data-off="Hide" data-width="100%" type="checkbox" name="status">
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block"><span class="fa fa-send"></span> Advertisement Update</button>
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