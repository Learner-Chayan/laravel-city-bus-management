<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
    <style>
        .ticket{
            text-align: left;
            margin-top: -41px;
        }
        .image{
            width: 30%;
            height: 50px;
            float: left;
        }
        .serial{
            width: 70%;
            height: 50px;
            background: #3a3939;
            float: right;
            color: white;
        }
        .serial p{
            /*padding-left: 7px;*/
            text-align: center;
            font-weight: bold;

        }
        .barcode{
            margin-top: -12px;
            width: 100%;
            height: 40px;
        }

    </style>
</head>
<body>
<div class="ticket">
    <div class="image">
        <img style="width: 100%; height: 100%" src="{{asset('public/logo.png')}}" alt="">
    </div>
    <div class="serial">
        <p>Ticket Number-{{$ticket->serial}}</p>
    </div>
<pre>
<b>{{$ticket->from}} </b> To <b> {{$ticket->to}} </b>
Journey Date:{{\Carbon\Carbon::parse($ticket->trip_info->start_time)->format('d M,Y H:i a') }} 
Bus Name : <b> {{$ticket->bus->name}} ({{$ticket->bus->coach_number}}) </b>
Issued by : <b> {{$issued_by}} </b>
Fare:<b>{{$ticket->fare_amount}} BDT({{$ticket->payment_by}}) </b>
Total seat : <b> {{$ticket->total_seat}}  </b>
@if($ticket->isStudent)
Passenger type : <b> Student </b>
@endif
</pre>
    <div class="barcode">
        @php
            $generator = new \Picqer\Barcode\BarcodeGeneratorHTML();
            echo $generator->getBarcode($ticket->serial, $generator::TYPE_CODE_128);
        @endphp
    </div>

</div>
</body>
</html>
