@extends('admin.layout.layout')
@section('content')

    <div class="row">
        <div class="col-lg-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img id="blah" src="{{ asset('public/images/user')}}/{{ $user->image }}" class="rounded-circle" alt="">
                        <h5 class="mt-3 mb-1 text-uppercase">{{ $user->name }}</h5>
                        <p>{{ Auth::user()->roles()->pluck('name')->implode(' , ') }}</p>
                        <h5 class="mt-3 mb-1 icon-phone"> {{ $user->phone }}</h5>
                        <h5 class="mt-3 mb-1 icon-envelope"> {{ $user->email }}</h5>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <div class="basic-form">
                       {!! Form::open(['route'=>['update-profile'],'method'=>'POST','files'=>'true' ]) !!}
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="text-uppercase">First Name<code>*</code></label>
                                    <input type="text" class="form-control" name="name" value="{{$user->name}}" placeholder="First Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="text-uppercase">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" value="{{$user->last_name}}" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="text-uppercase">Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{$user->phone}}" placeholder="Phone">
                            </div>
                            <div class="form-group">
                                <label class="text-uppercase ">Email<code>*</code></label>
                                <input type="email" class="form-control" name="email" value="{{$user->email}}" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label class="text-uppercase ">Profile Picture</label>
                                <input class="form-control" accept="image/*" name="image" type='file' id="imgInp" />
                            </div>
                            <button type="submit" class="btn btn-dark btn-block icon-paper-plane"> Update</button>
                       {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    </script>

@endpush
