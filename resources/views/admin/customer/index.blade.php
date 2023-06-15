@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <button class="btn btn-primary uppercase text-bold float-right" data-toggle="modal" data-target="#addModal"> New Customer</button>
                    <div class="table-responsive" style="overflow-x: hidden">
                        <table id="example" class="table table-striped table-bordered zero-configuration">
                            <thead>
                            <tr>
                                <th class="text-bold text-uppercase">#SL</th>
                                <th class="text-bold text-uppercase">Image</th>
                                <th class="text-bold text-uppercase">Name</th>
                                <th class="text-bold text-uppercase">Phone</th>
                                <th class="text-bold text-uppercase">Email</th>
                                <th class="text-bold text-uppercase">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($customers as $key => $customer)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>
                                        @if($customer->image == null)
                                            <img width="50" src="{{asset('public/default.png')}}" alt="Customer Image">
                                        @else
                                            <img width="50" src="{{asset('public/images/user')}}/{{$customer->image}}" alt="Customer Image">
                                        @endif
                                    </td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->email }}</td>
{{--                                    <td>{{ $customer->address }}</td>--}}
                                    <td>
{{--                                        <a href="#" class="btn btn-sm btn-primary fa fa-list"> Bus List</a>--}}
                                        <button class="btn btn-sm btn-primary fa fa-edit" data-toggle="modal" data-target="#editModal" onclick="showFormData({{$customer}})"> Edit</button>
                                        @can('destroy')
                                            {!! Form::button('<i class="fa fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger bold uppercase delete_button','data-toggle'=>"modal",'data-target'=>"#DelModal",'data-id'=>$customer->id]) !!}
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
                    <form action="{{route('customer.destroy',0)}}" method="post" id="deleteForm">
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
            <form id="customerForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Make Customer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="customer-name" class="col-form-label">Customer Name:</label>
                            <input type="text" class="form-control" id="customer-name" name="name">

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
                            <label for="email" class="col-form-label">Address:</label>
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

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="updatecustomerForm" enctype="multipart/form-data">
                <input type="hidden" id="customer_id" name="id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Update Customer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="customer-name" class="col-form-label">Customer Name:</label>
                            <input type="text" class="form-control" id="edit_customer_name" name="name">

                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-form-label">Phone:</label>
                            <input type="text" class="form-control" id="edit_phone" name="phone">

                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="email" class="form-control" id="edit_email" name="email">

                        </div>
                        <div class="form-group">
                            <label for="image" class="col-form-label">Image:</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Address:</label>
                            <input type="text" class="form-control" id="edit_address" name="address">

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
                 var url = '{{ route("customer.destroy",":id") }}';
                 url = url.replace(':id',id);
                 $("#deleteForm").attr("action",url);
                 $("#delete_id").val(id);
             });

            //add form
            $("#customerForm").on("submit",function(e){
                e.preventDefault();
                let form = $("#customerForm");
                const formdata = new FormData(form[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //ajax
                $.ajax({
                    method:"POST",
                    url: "{{route('customer.store')}}",
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
            $("#updatecustomerForm").on("submit",function(e){
                e.preventDefault();
                let form = $("#updatecustomerForm");
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
                    url: "{{route('customer-update')}}",
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
            console.log(data);

            $("#customer_id").val(data.id);
            $("#edit_customer_name").val(data.name);
            $("#edit_phone").val(data.phone);
            $("#edit_email").val(data.email);
            $("#edit_address").val(data.address);

        }
    </script>
@endpush
