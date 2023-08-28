@extends('admin.layout.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <hr/>

                    <div class="row">
                        <div class="col-12">

                            <h5 >Route : <span style="opacity:0.5">  {{$route_info->name}}  </span> </h5>
                            <h5 >Ticket Checker : <span style="opacity:0.5">  {{$trip_info->checker->name}}  </span> 
                                Driver : <span style="opacity:0.5"> {{$trip_info->driver->name}}  </span> 
                                Helper  : <span style="opacity:0.5"> {{$trip_info->helper->name}}  </span> </h5>
                            <h5>Total Tickets : {{$total_tickets}} , Total Amount  : {{$total_amount}} BDT</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table id="example" class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Ticket Number</th>
                                        <th>Amount (total passenger)</th>
                                        <th>Passenger type </th>
                                        <th>Issued by </th>
                                        <th>Payment by </th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                @php $i= 0; @endphp
                                <tboday>
                                    @foreach($ticket_sales as $info)
                                    <tr>
                                        <td>  @php $i++; @endphp {{ $i }}</td>
                                        <td>{{$info->serial}}</td>
                                        <td>{{ $info->fare_amount  }} BDT ({{ $info->total_seat}})</td>
                                        <td>@php echo $info->isStudent ? '<p class="text-info">Student </p>' : 'Normal' @endphp</td>
                                        <td>{{ $info->issued_by }}</td>
                                        <td>{{ $info->payment_by }}</td>
                                        <td>{{ $info->from }}</td>
                                        <td>{{ $info->to }}</td>
                                        <td>
                                             @if($info->status == 1)
                                               <span style="opacity:0.5"> Confirmed </span>
                                             @else
                                                    <a  href="{{route('ticket.status.update', $info->id)}}" class="text-success"> <u>Confirm now </u></a>
                                             @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <br/>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection