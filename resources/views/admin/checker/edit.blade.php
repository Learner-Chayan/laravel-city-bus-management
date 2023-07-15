@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @php($userDetails = \App\Models\UserDetails::where('user_id',$checker->id)->first())
                    <h4 class="card-title">{{$page_title}}</h4>
                    <form action="{{route('ticket-checker-update')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$checker->id}}">
                        <div class="form-group">
                            <label for="bus-name" class="col-form-label">Bus owner:</label>
                            <select name="owner_id" value="{{$checker->select2}}" class="select2 form-control" style="width: 100%">
                                <option value="">Select One</option>
                                @foreach($owners as $owner)
                                    <option value="{{$owner->id}}" {{$owner->id == $userDetails->owner_id ? 'selected' : ''}}>{{$owner->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="driver-name" class="col-form-label">Checker Name:</label>
                            <input type="text" class="form-control" value="{{$checker->name}}" name="name">

                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-form-label">Phone:</label>
                            <input type="text" class="form-control" value="{{$checker->phone}}" name="phone">

                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="email" class="form-control" value="{{$checker->email}}" name="email">

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

                        </div>
                        <div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Checker Image</label>
                                    <br>
                                    <img width="100" src="@if($checker->image !== null) {{asset('public/images/user')}}/{{$checker->image}} @else {{asset('public/default.png')}} @endif" alt="">
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
