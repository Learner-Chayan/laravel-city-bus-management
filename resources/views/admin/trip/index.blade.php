@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <button class="btn btn-primary uppercase text-bold float-right" data-toggle="modal" data-target="#addModal"> New trip</button>
                    <div class="table-responsive" style="overflow-x: hidden">
                        <table id="example" class="table table-striped table-bordered zero-configuration">
                            <thead>
                            <tr>
                                <th class="text-bold text-uppercase">#SL</th>
                                <th class="text-bold text-uppercase">Start Time</th>
                                <th class="text-bold text-uppercase">End Time</th>
                                <th class="text-bold text-uppercase">Route</th>
                                <th class="text-bold text-uppercase">Bus</th>
                                <th class="text-bold text-uppercase">Driver</th>
                                <th class="text-bold text-uppercase">Cotacter</th>
                                <th class="text-bold text-uppercase">Helper</th>
                                <th class="text-bold text-uppercase">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($trips as $key => $trip)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $trip->start_time }}</td>
                                    <td>{{ $trip->end_time }}</td>
                                    <td>{{ $routesArr[$trip->route] }}</td>
                                    <td>{{ $busesArr[$trip->bus] }}</td>
                                    <td>{{ $trip->driver }}</td>
                                    <td>{{ $trip->contacter }}</td>
                                    <td>{{ $trip->helper }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary fa fa-edit" data-toggle="modal" data-target="#editModal" onclick="showFormData({{$trip}})"> Edit</button>
                                         @can('trip-destroy') 
                                            {!! Form::button('<i class="fa fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger bold uppercase delete_button','data-toggle'=>"modal",'data-target'=>"#DelModal",'data-id'=>$trip->id]) !!}
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
                    <form action="{{route('trip.destroy',0)}}" method="post" id="deleteForm">
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
        <div class="modal-dialog modal-lg" role="document">
            <form id="tripForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Insert Trip</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="start_time" class="col-form-label">Start Time:</label>
                                    <input type="datetime-local" class="form-control" id="start_time" name="start_time">
                                </div>

                                <div class="form-group">
                                    <label for="end_time" class="col-form-label">End Time:</label>
                                    <input type="datetime-local" class="form-control" id="end_time" name="end_time">
                                </div>
                                <div class="form-group">
                                    <label for="route" class="col-form-label">Route:</label>
                                    <select class="form-control" id="route" name="route">
                                        <option value="">Select One</option>
                                        @foreach($routes as $route)
                                            <option value="{{$route->id}}">{{$route->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="driver" class="col-form-label">Driver:</label>
                                    <input type="text" class="form-control" id="driver" name="driver">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="helper" class="col-form-label">Helper:</label>
                                    <input type="text" class="form-control" id="helper" name="helper">
                                </div>
                                <div class="form-group">
                                    <label for="contacter" class="col-form-label">Contacter:</label>
                                    <input type="text" class="form-control" id="contacter" name="contacter">
                                </div>
                                <div class="form-group">
                                    <label for="bus" class="col-form-label">Bus :</label>
                                    <select class="form-control" id="bus" name="bus">
                                        <option value="">Select One</option>
                                        @foreach($buses as $bus)
                                            <option value="{{$bus->id}}">{{$bus->name}}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger" id="error"></p>
                                    <p class="text-success" id="success"></p>
                                </div>
                            </div>
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
        <div class="modal-dialog modal-lg" role="document">
            <form id="updatetripForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Update trip</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                    <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="edit_start_time" class="col-form-label">Start Time:</label>
                                    <input type="datetime-local" class="form-control" id="edit_start_time" name="start_time">
                                </div>

                                <div class="form-group">
                                    <label for="end_time" class="col-form-label">End Time:</label>
                                    <input type="datetime-local" class="form-control" id="edit_end_time" name="end_time">
                                </div>
                                <div class="form-group">
                                    <label for="edit_route" class="col-form-label">Route:</label>
                                    <select class="form-control" id="edit_route" name="route">
                                        <option value="">Select One</option>
                                        @foreach($routes as $route)
                                            <option value="{{$route->id}}">{{$route->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="edit_driver" class="col-form-label">Driver:</label>
                                    <input type="text" class="form-control" id="edit_driver" name="driver">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="edit_helper" class="col-form-label">Helper:</label>
                                    <input type="text" class="form-control" id="edit_helper" name="helper">
                                </div>
                                <div class="form-group">
                                    <label for="edit_contacter" class="col-form-label">Contacter:</label>
                                    <input type="text" class="form-control" id="edit_contacter" name="contacter">
                                </div>
                                <div class="form-group">
                                    <label for="edit_bus" class="col-form-label">Bus :</label>
                                    <select class="form-control" id="edit_bus" name="bus">
                                        <option value="">Select One</option>
                                        @foreach($buses as $bus)
                                            <option value="{{$bus->id}}">{{$bus->name}}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger" id="error"></p>
                                    <p class="text-success" id="success"></p>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="id" name="id">
    
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
                var url = '{{ route("trip.destroy",":id") }}';
                url = url.replace(':id',id);
                $("#deleteForm").attr("action",url);
                $("#delete_id").val(id);
            });

            //add form
            $("#tripForm").on("submit",function(e){
                makeDisable(true);
                e.preventDefault();
                let form = $("#tripForm");
                let formdata = new FormData(form[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //ajax
                $.ajax({
                    method:"POST",
                    url: "{{route('trip.store')}}",
                    data: formdata,
                    //data: name,
                    cache:false,
                    processData:false,
                    contentType:false,
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
            $("#updatetripForm").on("submit",function(e){
                makeDisable(true);
                e.preventDefault();

                let id = $("#id").val();
                let start_time = $("#edit_start_time").val();
                let end_time =  $("#edit_end_time").val();
                let route =  $("#edit_route").val();
                let driver =  $("#edit_driver").val();
                let helper =  $("#edit_helper").val();
                let contacter =  $("#edit_contacter").val();
                let bus =  $("#edit_bus").val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                // formdata is not working with update
                $.ajax({
                    method:"PUT",
                    url: "{{route('trip.update',"+id+")}}",
                    data: {
                        "id":id,
                        "start_time":start_time,
                        "end_time":end_time,
                        "route":route,
                        "driver":driver,
                        "helper":helper,
                        "contacter":contacter,
                        "bus":bus,
                    },

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
            $("#edit_start_time").val(data.start_time);
            $("#edit_end_time").val(data.end_time);
            $("#edit_route").val(data.route);
            $("#edit_driver").val(data.driver);
            $("#edit_helper").val(data.helper);
            $("#edit_contacter").val(data.contacter);
            $("#edit_bus").val(data.bus);
        }
    </script>
@endpush
