@extends('admin.layout.layout')


@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header">
                        <h2 class="box-title text-uppercase text-bold">{{$page_title}}</h2>
                        <div class="pull-right box-tools">
                            <div class="float-right mt-1">
                                <a class="btn bg-light-blue-active uppercase text-bold" href="{{ route('advertisement-create') }}"> New Advertisement</a>
                            </div>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="table-responsive">
                            <div class="col-lg-12">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="" class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Advert Type</th>
                                                <th>Advert Size</th>
                                                <th>Advert View</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($advertisement as $key => $add)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>
                                                        @if($add->advert_type == 1)
                                                            <span class="btn btn-primary bold"><i class="fa fa-check"></i> Own Advertisement</span>
                                                        @else
                                                            <span class="btn btn-success bold"><i class="fa fa-google"></i> Google Advertisement</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($add->advert_size == 1)
                                                            <span class="btn btn-primary bold"><i class="fa fa-arrows"></i> 300X600</span>
                                                        @elseif($add->advert_size == 2)
                                                            <span class="btn btn-primary bold"><i class="fa fa-arrows"></i> 300X250</span>
                                                        @elseif($add->advert_size == 3)
                                                            <span class="btn btn-primary bold"><i class="fa fa-arrows"></i> 728X90</span>
                                                        @elseif($add->advert_size == 4)
                                                            <span class="btn btn-primary bold"><i class="fa fa-arrows"></i> 970X90</span>
                                                        @elseif($add->advert_size == 5)
                                                            <span class="btn btn-primary bold"><i class="fa fa-arrows"></i> 970X250</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $add->hit }} - Views</td>
                                                    <td>
                                                        @if($add->status == 0)
                                                            <span class="btn btn-danger bold"><i class="fa fa-times"></i> Deactivated</span>
                                                        @else
                                                            <span class="btn btn-primary bold"><i class="fa fa-check"></i> Active</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('advertisement-edit',$add->id) }}" class="btn btn-primary bold uppercase btn-sm"><i class="fa fa-edit"></i> Edit</a>
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
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col-->
        </div>
        <!-- ./row -->
    </section>
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
                    <form action="{{route('sliders.destroy',0)}}" method="post" id="deleteForm">
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
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            $(document).on("click", '.delete_button', function (e) {
                var id = $(this).data('id');
                var url = '{{ route("sliders.destroy",":id") }}';
                url = url.replace(':id',id);
                $("#deleteForm").attr("action",url);
                $("#delete_id").val(id);
            });
        });
    </script>
@endpush