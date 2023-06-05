@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <a class="btn btn-primary uppercase text-bold float-right" href="{{ route('socials.create') }}"> New Social</a>
                    <div class="table-responsive" style="overflow-x: hidden">
                        <table id="example" class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>#SL</th>
                                    <th class="text-bold text-uppercase">Title</th>
                                    <th class="text-bold text-uppercase">Code</th>
                                    <th class="text-bold text-uppercase">Link</th>
                                    <th class="text-bold text-uppercase"> Status</th>
                                    <th class="text-bold text-uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($socials as $key => $socials)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ Str::limit($socials->title, 50) }}</td>
                                    <td>{{ Str::limit($socials->code, 50) }}</td>
                                    <td>{{ Str::limit($socials->link, 50) }}</td>
                                    <td>
                                        @if($socials->status == 1)
                                            <label for="" class="badge btn btn-success fa fa-check"> Active</label>
                                        @else
                                            <label for="" class="badge btn btn-danger fa fa-times"> Deactivated</label>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-primary fa fa-edit" href="{{ route('socials.edit',$socials->id) }}"> Edit</a>
                                        @can('delete')
                                            {!! Form::button('<i class="fa fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger bold uppercase delete_button','data-toggle'=>"modal",'data-target'=>"#DelModal",'data-id'=>$socials->id]) !!}
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
                    <form action="{{route('socials.destroy',0)}}" method="post" id="deleteForm">
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
                var url = '{{ route("socials.destroy",":id") }}';
                url = url.replace(':id',id);
                $("#deleteForm").attr("action",url);
                $("#delete_id").val(id);
            });
        });
    </script>
@endpush
