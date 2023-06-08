@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <button class="btn btn-primary uppercase text-bold float-right" data-toggle="modal" data-target="#addModal"> New Stoppage</button>
                    <div class="table-responsive" style="overflow-x: hidden">
                        <table id="example" class="table table-striped table-bordered zero-configuration">
                            <thead>
                            <tr>
                                <th class="text-bold text-uppercase">#SL</th>
                                <th class="text-bold text-uppercase">Name</th>
                                <th class="text-bold text-uppercase">Status</th>
                                <th class="text-bold text-uppercase">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($stoppages as $key => $stoppage)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $stoppage->name }}</td>
                                    <td>
                                        @if($stoppage->status == 1 )
                                            <label class="label label-success">Active</label>
                                        @else
                                            <label for="" class="label label-danger"> Hide</label>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary fa fa-edit" data-toggle="modal" data-target="#editModal" onclick="showFormData({{$stoppage}})"> Edit</button>
                                        @can('destroy')
                                            {!! Form::button('<i class="fa fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger bold uppercase delete_button','data-toggle'=>"modal",'data-target'=>"#DelModal",'data-id'=>$stoppage->id]) !!}
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
                    <form action="{{route('stoppage.destroy',0)}}" method="post" id="deleteForm">
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
            <form id="stoppageForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Insert Stoppage</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="form-group">
                                <label for="stoppage-name" class="col-form-label">Stoppage Name:</label>
                                <input type="text" class="form-control" id="stoppage-name" name="name">
                                <p class="text-danger" id="error"></p>
                                <p class="text-success" id="success"></p>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submit_btn">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="updateStoppageForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Update Stoppage</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                            <div class="form-group">
                                <label for="status" class="col-form-label">Status:</label>
                                <select id="editStatus" class="form-control" name="status" >
                                    <option value="1">Show<option>
                                    <option value="0">Hide<option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="stoppage-name" class="col-form-label">Stoppage Name:</label>
                                <input type="text" class="form-control" id="editStoppage-name" name="name">
                                <p class="text-danger" id="updateError"></p>
                                <p class="text-success" id="updateSuccess"></p>

                                <input type="hidden" id="id">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submit_btn">Update</button>
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
                var url = '{{ route("stoppage.destroy",":id") }}';
                url = url.replace(':id',id);
                $("#deleteForm").attr("action",url);
                $("#delete_id").val(id);
            });

            //add form
            $("#stoppageForm").on("submit",function(e){
                makeDisable(true);
                e.preventDefault();
                let name = $("#stoppage-name").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //ajax
                $.ajax({
                    method:"POST",
                    url: "{{route('stoppage.store')}}",
                    data: {"name":name},
                    //data: name,
                    success:function(res){
                        console.log(res);
                       // $("#error").text('res');

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
            $("#updateStoppageForm").on("submit",function(e){
                makeDisable(true);
                e.preventDefault();
                let name = $("#editStoppage-name").val();
                let id = $("#id").val();
                let status = $("#editStatus").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //ajax
                $.ajax({
                    method:"PUT",
                    url: "{{route('stoppage.update',"+id+")}}",
                    data: {"name":name,id:id,"status":status},
                    success:function(res){
                        console.log(res);
                       toastr.success("Updated Successfully !!");
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
            console.log(data);

            $("#id").val(data.id);
            $("#editStoppage-name").val(data.name);
            $("#editStatus").val(data.status);
        }
    </script>
@endpush
