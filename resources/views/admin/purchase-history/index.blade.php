@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>

                    <div class="row">
                        <div class="col-12">
                            <table id="example" class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Ticket Number</th>
                                        <th>Issue date</th>
                                        <th>Journey Date </th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Download</th>
                                    </tr>
                                </thead>
                                @php $i= 0; @endphp
                                <tboday>
                                    @foreach($ticket_sales as $info)
                                    <tr>
                                        <td>  @php $i++; @endphp {{ $i }}</td>
                                        <td>{{$info->serial}}</td>
                                        <td>{{ \Carbon\Carbon::parse($info->created_at)->format('d M,Y H:i a') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($info->trip_info->start_time)->format('d M,Y H:i a') }}</td>
                                        <td>{{ $info->from }}</td>
                                        <td>{{ $info->to }}</td>
                                        <td><a href="{{route('ticket-pdf',$info->id)}}" class="btn btn-default"><i class="fa fa-download"></i></a></td>
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

@endsection