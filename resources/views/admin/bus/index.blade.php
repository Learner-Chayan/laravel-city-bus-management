@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <button class="btn btn-primary uppercase text-bold float-right" data-toggle="modal" data-target="#addModal"> New Bus</button>
                    <div class="table-responsive" style="overflow-x: hidden">
                        <table id="example" class="table table-striped table-bordered zero-configuration">
                            <thead>
                            <tr>
                                <th class="text-bold text-uppercase">#SL</th>
                                <th class="text-bold text-uppercase">Name</th>
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
                                    <td>{{ $bus->name }}</td>
                                    <td>{{ $bus->reg_number }}</td>
                                    <td>{{ $bus->reg_last_date }}</td>
                                    <td>{{ $bus->reg_image }}</td>
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
                                <label for="bus-name" class="col-form-label">Bus Name:</label>
                                <input type="text" class="form-control" id="bus-name" name="name">

                            </div>
                            <div class="form-group">
                                <label for="bus-name" class="col-form-label">Reg Number:</label>
                                <input type="text" class="form-control" id="reg-number" name="reg_number">

                            </div>
                            <div class="form-group">
                                <label for="bus-name" class="col-form-label">Reg Last Date:</label>
                                <input type="text" class="form-control" id="reg-last-date" name="reg_last_date">

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
                                <label for="bus-name" class="col-form-label">Bus Name:</label>
                                <input type="text" class="form-control" id="edit-bus-name" name="name">

                            </div>
                            <div class="form-group">
                                <label for="bus-name" class="col-form-label">Reg Number:</label>
                                <input type="text" class="form-control" id="edit-reg-number" name="reg_number">

                            </div>
                            <div class="form-group">
                                <label for="bus-name" class="col-form-label">Reg Last Date:</label>
                                <input type="text" class="form-control" id="edit-reg-last-date" name="reg_last_date">

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
                       // $("#error").text('res');

                       $("#success").text("Inserted Successfully !!");
                        setTimeout(()=>{ $("#success").text(''); },3000);
                    },
                    error:function(err){
                        console.log(err);
                        const msg = JSON.parse(err.responseText).message;
                        $("#error").text(msg);
                        setTimeout(()=>{ $("#error").text(''); },3000);
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
                       $("#updateSuccess").text("Updated Successfully !!");
                        setTimeout(()=>{ $("#updateSuccess").text(''); },3000);
                    },
                    error:function(err){
                        console.log(err);
                        const msg = JSON.parse(err.responseText).message;
                        $("#updateError").text(msg);
                        setTimeout(()=>{ $("#updateError").text(''); },3000);
                    },


            })

            });

         });

        function showFormData(data){
            console.log(data);

            $("#edit-id").val(data.id);
            $("#edit-bus-name").val(data.name);
            $("#edit-reg-number").val(data.reg_number);
            $("#edit-reg-last-date").val(data.reg_last_date);

        }
    </script>
@endpush
