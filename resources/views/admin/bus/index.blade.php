@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    @can(['bus-create'])
                        <button class="btn btn-primary uppercase text-bold float-right" data-toggle="modal" data-target="#addModal"> New Bus</button>
                    @endcan
                    <div class="table-responsive" style="overflow-x: hidden">
                        <table id="example" class="table table-striped table-bordered zero-configuration">
                            <thead>
                            <tr>
                                <th class="text-bold text-uppercase">#SL</th>
                                <th class="text-bold text-uppercase">Owner</th>
                                <th class="text-bold text-uppercase">Bus Name</th>
                                <th class="text-bold text-uppercase">Total Seat</th>
                                <th class="text-bold text-uppercase">Reg Number</th>
                                <th class="text-bold text-uppercase">Reg Last Date</th>
                                <th class="text-bold text-uppercase">Reg Image</th>
                                <th class="text-bold text-uppercase">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($buses as $key => $bus)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $bus->owner->name }}</td>
                                    <td>{{ $bus->name }}-{{$bus->coach_number}}</td>
                                    <td>{{ $bus->seat_number }}</td>
                                    <td>{{ $bus->reg_number }}</td>
                                    <td>{{ $bus->reg_last_date }}</td>
                                    <td><img width="50" src="{{asset("public/images/bus/$bus->reg_image")}}" alt="buss number plate image"></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary fa fa-edit" data-toggle="modal" data-target="#editModal" onclick="showFormData({{$bus}})"> Edit</button>
                                        @can('destroy')
                                            {!! Form::button('<i class="fa fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger bold uppercase delete_button','data-toggle'=>"modal",'data-target'=>"#DelModal",'data-id'=>$bus->id]) !!}
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
                    <form action="{{route('bus.destroy',0)}}" method="post" id="deleteForm">
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
            <form id="busForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Insert Bus</h5>
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
                            <label for="bus-name" class="col-form-label">Bus Name:</label>
                            <input type="text" class="form-control" id="bus-name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="bus-name" class="col-form-label">Coach Number: <code>This number is unique</code></label>
                            <input type="text" class="form-control" id="coach_number" name="coach_number">
                        </div>
                        <div class="form-group">
                            <label for="bus-name" class="col-form-label">Total Seat:</label>
                            <input type="text" class="form-control" id="bus-seat" name="seat_number">
                        </div>
                        <div class="form-group">
                            <label for="bus-name" class="col-form-label">Reg Number:</label>
                            <input type="text" class="form-control" id="reg-number" name="reg_number">
                        </div>
                        <div class="form-group">
                            <label for="bus-name" class="col-form-label">Reg Last Date:</label>
                            <input type="date" class="form-control" id="reg-last-date" name="reg_last_date">
                        </div>
                        <div class="form-group">
                            <label for="bus-name" class="col-form-label">Reg Image:</label>
                            <input type="file" class="form-control" id="reg-image" name="reg_image">
                            <p class="text-danger" id="error"></p>
                            <p class="text-success" id="success"></p>
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

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="updatebusForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Update Stoppage</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bus-name" class="col-form-label">Bus owner:</label>
                            <select name="owner_id" id="edit_owner_id" class="select2 form-control" style="width: 100%">
                                <option value="">Select One</option>
                                @foreach($owners as $owner)
                                    <option value="{{$owner->id}}">{{$owner->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bus-name" class="col-form-label">Bus Name:</label>
                            <input type="text" class="form-control" id="edit-bus-name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="bus-name" class="col-form-label">Coach Number: <code>This number is unique</code></label>
                            <input type="text" class="form-control" id="edit_coach_number" name="coach_number">
                        </div>
                        <div class="form-group">
                            <label for="bus-name" class="col-form-label">Total Seat:</label>
                            <input type="text" class="form-control" id="edit_bus-seat" name="seat_number">
                        </div>
                        <div class="form-group">
                            <label for="bus-name" class="col-form-label">Reg Number:</label>
                            <input type="text" class="form-control" id="edit-reg-number" name="reg_number">

                        </div>
                        <div class="form-group">
                            <label for="bus-name" class="col-form-label">Reg Last Date:</label>
                            <input type="date" class="form-control" id="edit-reg-last-date" name="reg_last_date">

                        </div>
                        <div class="form-group">
                            <label for="bus-name" class="col-form-label">Reg Image:</label>
                            <input type="file" class="form-control" id="edit-reg-image" name="reg_image">
                            <p class="text-danger" id="updateError"></p>
                            <p class="text-success" id="updateSuccess"></p>

                            <input type="hidden" id="edit-id" name="id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
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
                 var url = '{{ route("bus.destroy",":id") }}';
                 url = url.replace(':id',id);
                 $("#deleteForm").attr("action",url);
                 $("#delete_id").val(id);
             });

            //add form
            $("#busForm").on("submit",function(e){
                e.preventDefault();
                let form = $("#busForm");
                const formdata = new FormData(form[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //ajax
                $.ajax({
                    method:"POST",
                    url: "{{route('bus.store')}}",
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
            $("#updatebusForm").on("submit",function(e){
                e.preventDefault();
                let form = $("#updatebusForm");
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
                    url: "{{route('bus-update')}}",
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

        function showFormData(data){
            let ownerId = JSON.parse(data.owner_id);
            $('#edit_owner_id').val(ownerId).trigger('change');

            $("#edit-id").val(data.id);
            $("#edit_bus-seat").val(data.seat_number);
            $("#edit-bus-name").val(data.name);
            $("#edit_coach_number").val(data.coach_number);
            $("#edit-reg-number").val(data.reg_number);
            $("#edit-reg-last-date").val(data.reg_last_date);

        }
    </script>
@endpush
