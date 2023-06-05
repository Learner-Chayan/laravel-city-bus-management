@extends('admin.layout.layout')
@push('css')
    <style>
        .hello{
            height: 200px;
            width: 300px;
        }
    </style>
@endpush
@section('content')

    <div class="row">
        <div class="col-lg-10 offset-1">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <div class="basic-form">
                        {!! Form::open(['route'=>['sliders.update',$slider->id],'method'=>'put','files' => true]) !!}
                        <div class="form-group">
                            <label class="text-bold text-uppercase">Slider Title</label>
                            <input type="text" class="form-control"  name="title" value="{{$slider->title}}" required placeholder="Slider Title">
                        </div>
                        <div class="input-group">
                            <img id='img-upload' src="{{ asset('public/images/slider')}}/{{ $slider->image }}"/>
                        </div>
                        <br>

                        <div class="form-group">
                            <label class="text-bold text-uppercase">Slider Image</label>
                            <input type="file" class="form-control" name="image" id="imgInp" >
                        </div>
                        <div class="form-group">
                            <label class="text-bold text-uppercase">Slider Description</label>
                            <textarea class="summernote" style="height: 100px;" name="description">{!! $slider->description !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="text-bold text-uppercase">Status</label>
                            <input data-toggle="toggle" data-onstyle="success" {{$slider->status == 1 ? 'checked' : ''}} data-offstyle="danger" data-on="Active" data-off="Deactivate" data-width="100%" type="checkbox" name="status">
                        </div>

                        <button type="submit" class="btn btn-dark btn-block icon-paper-plane"> Slider Update</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        $(document).ready( function() {
            $(document).on('change', '.btn-file :file', function() {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function(event, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = label;

                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }

            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img-upload').attr('src', e.target.result);
                        $( "#img-upload" ).addClass( "hello" );
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp").change(function(){
                readURL(this);
            });
        });
    </script>

@endpush
