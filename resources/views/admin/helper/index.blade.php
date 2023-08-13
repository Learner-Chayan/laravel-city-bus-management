@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <button class="btn btn-primary uppercase text-bold float-right" data-toggle="modal" data-target="#addModal"> New Helper</button>
                    <div class="table-responsive" style="overflow-x: hidden">
                        <table id="example" class="table table-striped table-bordered zero-configuration">
                            <thead>
                            <tr>
                                <th class="text-bold text-uppercase">#SL</th>
                                <th class="text-bold text-uppercase">Image</th>
                                <th class="text-bold text-uppercase">Name</th>
                                <th class="text-bold text-uppercase">Owner</th>
                                <th class="text-bold text-uppercase">Phone</th>
                                <th class="text-bold text-uppercase">Email</th>
                                <th class="text-bold text-uppercase">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($helpers as $key => $helper)
                                @php
                                    $userDetails = \App\Models\UserDetails::where('user_id',$helper->id)->first();
                                    $owner = \App\User::findOrFail($userDetails->owner_id);
                                @endphp
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td><img width="75" src="@if($helper->image !== null) {{asset('public/images/user')}}/{{$helper->image}} @else {{asset('public/default.png')}} @endif" alt="Helper Image"></td>
                                    <td>{{ $helper->name }}</td>
                                    <td>{{ $owner->name }}</td>
                                    <td>{{ $helper->phone }}</td>
                                    <td>{{ $helper->email }}</td>
{{--                                    <td>{{ $helper->address }}</td>--}}
                                    <td>
{{--                                        <a href="#" class="btn btn-sm btn-primary fa fa-list"> Bus List</a>--}}
                                        <a href="{{route('helper.edit',$helper->id)}}" class="btn btn-sm btn-primary fa fa-edit" > Edit</a>
                                        @can('destroy')
                                            {!! Form::button('<i class="fa fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger bold uppercase delete_button','data-toggle'=>"modal",'data-target'=>"#DelModal",'data-id'=>$helper->id]) !!}
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header bg-orange-active text-center">
                    <h4 class="modal-title" id="myModalLabel2"><i class='fa fa-trash'></i> Delete !</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Are you sure you want to Delete ?</strong>
                </div>
                <div class="modal-footer">
                    <form action="{{route('helper.destroy',0)}}" method="post" id="deleteForm">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <input type="hidden" name="id" id="delete_id" class="delete_id" value="0">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-danger deleteButton"><i class="fa fa-trash"></i> DELETE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="helperForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Make Bus Helper</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bus-name" class="col-form-label">Bus owner:</label>
                            <select name="owner_id" id="owner_id" class="select2 form-control" style="width: 100%">
                                <option value="">Select One</option>
                                @foreach($owners as $owner)
                                    <option value="{{$owner->id}}">{{$owner->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="helper-name" class="col-form-label">Helper Name:</label>
                            <input type="text" class="form-control" id="helper-name" name="name">

                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-form-label">Phone:</label>
                            <input type="text" class="form-control" id="phone" name="phone">

                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email">

                        </div>
                        <div class="form-group">
                            <label for="image" class="col-form-label">Image:</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-form-label">Address:</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection
@push('js')
   <script>
        $(document).ready(function () {
            $(document).on("click", '.delete_button', function (e) {
                 var id = $(this).data('id');
                 var url = '{{ route("helper.destroy",":id") }}';
                 url = url.replace(':id',id);
                 $("#deleteForm").attr("action",url);
                 $("#delete_id").val(id);
             });

            //add form
            $("#helperForm").on("submit",function(e){
                e.preventDefault();
                let form = $("#helperForm");
                const formdata = new FormData(form[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //ajax
                $.ajax({
                    method:"POST",
                    url: "{{route('helper.store')}}",
                    data: formdata,
                    cache:false,
                    processData:false,
                    contentType:false,
                    success:function(res){
                        console.log(res);
                        toastr.success("Inserted Successfully !!");
                        reload();
                    },
                    error:function(err){
                        console.log(err);
                        const msg = JSON.parse(err.responseText).message;
                        toastr.error(msg);
                        makeDisable(false);
                    }
                })

            });


            //update form
            $("#updatehelperForm").on("submit",function(e){
                e.preventDefault();
                let form = $("#updatehelperForm");
                const formdata = new FormData(form[0]);
                const id = $("#edit-id").val();


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //ajax
                $.ajax({
                    method:"post",
                    url: "{{route('helper-update')}}",
                    data: formdata,
                    cache:false,
                    processData:false,
                    contentType:false,
                    success:function(res){
                        console.log(res);
                        toastr.success("Inserted Successfully !!");
                        reload();
                    },
                    error:function(err){
                        console.log(err);
                        const msg = JSON.parse(err.responseText).message;
                        toastr.error(msg);
                        makeDisable(false);
                    }

            })

            });

         });


    </script>
@endpush
