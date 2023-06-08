@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
{{--                    <h4 class="card-title">{{$page_title}}</h4>--}}
                    <button class="btn btn-primary uppercase text-bold float-right" data-toggle="modal" data-target="#addModal"> New Route</button>
                    <div class="table-responsive" style="overflow-x: hidden">
                        <table id="example" class="table table-striped table-bordered zero-configuration">
                            <thead>
                            <tr>
                                <th class="text-bold text-uppercase">#SL</th>
                                <th class="text-bold text-uppercase">Name</th>
                                <th class="text-bold text-uppercase">Stoppage</th>
                                <th class="text-bold text-uppercase">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($routes as $key => $route)
                                @php($stoppageIds = json_decode($route->stoppage_id))
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $route->name }}</td>
                                    <td>
                                        <ol>
                                            @foreach($stoppageIds as $key => $stop)
                                                @php($stoppage = \App\Models\Stopage::findOrFail($stop))
                                                    <li>{{$stoppage->name}}</li>
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary fa fa-edit" data-toggle="modal" data-target="#editModal" onclick="showFormData({{$route}})"> Edit</button>
                                        @can('destroy')
                                            {!! Form::button('<i class="fa fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger bold uppercase delete_button','data-toggle'=>"modal",'data-target'=>"#DelModal",'data-id'=>$route->id]) !!}
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
                    <form action="{{route('route.destroy',0)}}" method="post" id="deleteForm">
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


{{--    addModal--}}
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="routeForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Insert Route</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="form-group">
                                <label for="route-name" class="col-form-label">Route Name:</label>
                                <input type="text" class="form-control" id="route-name" name="name">

                            </div>

                            <div class="form-group">
                                <label for="status" class="col-form-label">Stoppage:</label>
                                <select id="stoppage_id" class="form-control select2" name="stoppage_id[]" multiple style="width: 100%" >
                                    @foreach($stoppages as $stoppage)

                                        <option value="{{$stoppage->id}}">{{$stoppage->name}}<option>
                                    @endforeach
                                </select>
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

{{--    editModal--}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="updaterouteForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Update Stoppage</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="route-name" class="col-form-label">Route Name:</label>
                            <input type="text" class="form-control" id="edit-route-name" name="name">

                        </div>

                        <div class="form-group">
                            <label for="status" class="col-form-label">Stoppage:</label>
                            <select id="editStoppage_id" class="form-control select2" name="stoppage_id[]" multiple style="width: 100%">
                                @foreach($stoppages as $stoppage)
                                    <option value="{{$stoppage->id}}">{{$stoppage->name}}<option>
                                @endforeach
                            </select>
                            <p class="text-danger" id="error"></p>
                            <p class="text-success" id="success"></p>
                            <input type="hidden" id="route_id" name="id">
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
                 var url = '{{ route("route.destroy",":id") }}';
                 url = url.replace(':id',id);
                 $("#deleteForm").attr("action",url);
                 $("#delete_id").val(id);
             });

            //add form
            $("#routeForm").on("submit",function(e){
                makeDisable(true);
                e.preventDefault();
                let form = $("#routeForm");
                const formdata = new FormData(form[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //ajax
                $.ajax({
                    method:"POST",
                    url: "{{route('route.store')}}",
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
            $("#updaterouteForm").on("submit",function(e){
                makeDisable(true);
                e.preventDefault();
                let form = $("#updaterouteForm");
                const formdata = new FormData(form[0]);
                const id = $("#edit-route-id").val();


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //ajax
                $.ajax({
                    method:"POST",
                    url: "{{route('route-update')}}",
                    data: formdata,
                    cache:false,
                    processData:false,
                    contentType:false,
                    success:function(res){
                        console.log(res);
                        toastr.success("Updated Successfully");
                        reload();
                    },
                    error:function(err){
                        console.log(err);
                        const msg = JSON.parse(err.responseText).message;
                        toastr.error(msg);
                        makeDisable(false);

                    },


            })

            });

         });

        function showFormData(data){

            let stoppage_ids = JSON.parse(data.stoppage_id);
            $('#editStoppage_id').val(stoppage_ids).trigger('change');

             $("#route_id").val(data.id);
             $("#edit-route-name").val(data.name);
            // $("#edit-reg-number").val(data.reg_number);
            // $("#edit-reg-last-date").val(data.reg_last_date);

        }

    </script>
@endpush
