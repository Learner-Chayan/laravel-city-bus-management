@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>

                    <div class="row">
                        <div class="col-12">
                            <table class="table">
                                <tr>
                                    <th>SL</th>
                                    <th>Ticket Number</th>
                                    <th>Issue date</th>
                                    <th>Journey Date </th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Download</th>
                                </tr>
                                @php $i= 0; @endphp
                                @foreach($ticket_sales as $info)
                                <tr>
                                @php $i++; @endphp
                                    <td>{{ $i }}</td>
                                    <td>{{$info->serial}}</td>
                                    <td>{{ $info->created_at }}</td>
                                    <td>{{ $info->trip_info->start_time }}</td>
                                    <td>{{ $info->from }}</td>
                                    <td>{{ $info->to }}</td>
                                    <td><a href="{{route('ticket-pdf',$info->id)}}" class="btn btn-default"><i class="fa fa-download"></i></a></td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
