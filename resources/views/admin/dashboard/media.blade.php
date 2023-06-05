@extends('admin.layout.layout')

@push('css')
    <style>
        .folder {
            width: 150px;
            height: 105px;
            margin: 0 auto;
            position: relative;
            background-color: #708090;
            border-radius: 0 6px 6px 6px;
            box-shadow: 4px 4px 7px rgba(0, 0, 0, 0.59);
        }

        .folder:before {
            content: '';
            width: 50%;
            height: 12px;
            border-radius: 0 20px 0 0;
            background-color: #708090;
            position: absolute;
            top: -12px;
            left: 0px;
        }
    </style>
@endpush
@section('content')
    <div class="card ui-tab-card">
        <div class="card-body">
            <button class="btn-fill-sm text-light bg-linkedin" data-target="#createCategory" data-toggle="modal">Create Folder</button>
            <br>
            <br>
            <button class="btn-fill-sm text-light bg-skyblue mt-2" data-target="#fileUpload" data-toggle="modal"><i class="fas fa-plus fa-6x"></i></button>
            @foreach($category as $cat)

                <a href="{{route('media-category',$cat->id)}}" class="btn-fill-sm text-light bg-dark-high"><i class="fas fa-folder fa-6x"></i></a>&nbsp;&nbsp;&nbsp;
                <button style="margin-left: -52px;" data-id="{{$cat->id}}" onclick="CatDelete(event.target)" data-toggle="modal" class="btn-fill-sm text-light bg-martini fa fa-times"></button>
            @endforeach
            @foreach($media as $cat)

                <a href="{{route('file-download',$cat->file_name)}}" class="btn-fill-sm text-light bg-dark-high"><i class="fas fa-file fa-6x"></i></a>&nbsp;&nbsp;&nbsp;
                <button style="margin-left: -52px;" data-id="{{$cat->id}}" onclick="MediaDelete(event.target)" data-toggle="modal" class="btn-fill-sm text-light bg-martini fa fa-times"></button>
            @endforeach

        </div>
    </div>
    <!-- Exam Schedule Area Start Here -->
    <div id="createCategory" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel2">Media Folder Name</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form enctype="multipart/form-data" id="storeCategory">
                        <div class="form-group">
                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                            <input type="text" name="category_name" id="category_name" class="category_name form-control" placeholder="Folder Name">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" id="submit-edit" class="btn-fill-sm text-light bg-gradient-gplus">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="fileUpload" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel2">Upload Media</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" id="uploadFile">
                        <div class="form-group">
                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                            <input type="hidden" name="category_id" value="0">
                            <input type="file" name="attachment" id="file_name" class="file_name form-control" placeholder="File Upload">
                            <code>.png.jpg.jpeg are accepted</code>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" id="submit-edit" class="btn-fill-sm text-light bg-gradient-gplus">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="CatModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header bg-orange-active text-center">
                    <h4 class="modal-title" id="myModalLabel2"><i class='fa fa-trash'></i> Delete !</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Are you sure you want to Delete This Folder ?</strong>
                </div>
                <div class="modal-footer">
                    <form enctype="multipart/form-data" id="deleteCat">
                        <input type="" id="cat_id" name="cat_id">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> NO</button>
                        <button type="submit" class="btn btn-danger deleteButton"><i class="fa fa-trash"></i> YES</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="MediaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header bg-orange-active text-center">
                    <h4 class="modal-title" id="myModalLabel2"><i class='fa fa-trash'></i> Delete !</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Are you sure you want to Delete Media ?</strong>
                </div>
                <div class="modal-footer">
                    <form enctype="multipart/form-data" id="deleteMedia">
                        <input type="hidden" id="media_id" name="media_id">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> NO</button>
                        <button type="submit" class="btn btn-danger deleteButton"><i class="fa fa-trash"></i> YES</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')

    <script type="text/javascript">
        $('#storeCategory').on('submit',(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var dataForm;
            dataForm = new FormData(this);
            $.ajax({

                type:'POST',
                url: '{{ route("media-category-store") }}',
                data:dataForm,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data) {
                    // console.log(data)
                    if($.isEmptyObject(data.error)){
                        setTimeout(() => {
                            toastr.success("Successfully Update Category");
                            location.reload();
                        },500)
                    }else{
                        printErrorMsg(data.error);
                    }
                },
            });

            $('#createCategory').modal('toggle');
        }));

        $('#uploadFile').on('submit',(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var dataForm;
            dataForm = new FormData(this);
            // dataForm.append('attachment',$('#file_name').val());

            $.ajax({

                type:'POST',
                url: '{{ route("media.store") }}',
                data:dataForm,

                cache:false,
                contentType: false,
                processData: false,
                success: function(data) {
                    // console.log(data)
                    if($.isEmptyObject(data.error)){
                        setTimeout(() => {
                            toastr.success("Successfully Update Category");
                            location.reload();
                        },500)
                    }else{
                        printErrorMsg(data.error);
                    }
                },
            });

            $('#fileUpload').modal('toggle');
        }));
        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                toastr.warning(value);
                // $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
        function CatDelete(event) {
            var id = $(event).data("id");
            $('#cat_id').val(id);
            $('#CatModal').modal('show');
        }
        $('#deleteCat').on('submit',(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var formData;
            formData = new FormData(this);
            $.ajax({

                type:'POST',
                url: "{{ route('category-delete')}}",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,

                success:function(response){
                    // console.log(response);

                    setTimeout(() => {
                        toastr.success("Successfully Delete");
                        location.reload();
                    },500)
                },
                error:function(response){

                    setTimeout(() => {
                        toastr.warning("Please Check Error!");
                    },500)
                },
            });
            $('#CatModal').modal('toggle');
        }));

        function MediaDelete(event) {
            var id = $(event).data("id");
            $('#media_id').val(id);
            $('#MediaModal').modal('show');
        }
        $('#deleteMedia').on('submit',(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var formData;
            formData = new FormData(this);
            $.ajax({

                type:'POST',
                url: "{{ route('media-delete')}}",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,

                success:function(response){
                    // console.log(response);

                    setTimeout(() => {
                        toastr.success("Successfully Delete");
                        location.reload();
                    },500)
                },
                error:function(response){

                    setTimeout(() => {
                        toastr.warning("Please Check Error!");
                    },500)
                },
            });
            $('#MediaModal').modal('toggle');
        }));



    </script>
@endpush
