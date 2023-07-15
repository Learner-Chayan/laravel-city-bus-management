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
Journey Date:{{\Carbon\Carbon::parse($ticket->trip_info->start_time)->format('d M,Y H:i a') }}
Coach Number:{{$ticket->bus->coach_number}}
Bus Name:{{$ticket->bus->name}}
Form:{{$ticket->from}}
To:{{$ticket->to}}
Fare : {{$ticket->fare_amount}}
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
