@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @php($userDetails = \App\Models\UserDetails::where('user_id',$driver->id)->first())
                    <h4 class="card-title">{{$page_title}}</h4>
                    <form action="{{route('driver-update')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$driver->id}}">
                        <div class="form-group">
                            <label for="bus-name" class="col-form-label">Bus owner:</label>
                            <select name="owner_id" value="{{$driver->select2}}" class="select2 form-control" style="width: 100%">
                                <option value="">Select One</option>
                                @foreach($owners as $owner)
                                    <option value="{{$owner->id}}" {{$owner->id == $userDetails->owner_id ? 'selected' : ''}}>{{$owner->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="driver-name" class="col-form-label">Driver Name:</label>
                            <input type="text" class="form-control" value="{{$driver->name}}" name="name">

                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-form-label">Phone:</label>
                            <input type="text" class="form-control" value="{{$driver->phone}}" name="phone">

                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="email" class="form-control" value="{{$driver->email}}" name="email">

                        </div>
                        <div class="form-group">
                            <label for="address" class="col-form-label">Address:</label>
                            <input type="text" class="form-control" value="{{$userDetails->address}}" name="address">
                        </div>
                        <div class="row">

                            <div class="form-group col-6">
                                <label for="image" class="col-form-label">Image:</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                            <div class="form-group col-6">
                                <label for="image" class="col-form-label">Driving Licence</label>
                                <input type="file" class="form-control" name="licence">
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Driver Image</label>
                                    <br>
                                    <img width="100" src="@if($driver->image !== null) {{asset('public/images/user')}}/{{$driver->image}} @else {{asset('public/default.png')}} @endif" alt="">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Licence</label>
                                    <br>
                                    <img width="100" src="{{asset('public/images/user')}}/{{$userDetails->licence}}" alt="">

                                </div>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-dark btn-block icon-paper-plane"> Save</button>

                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('js')

@endpush
