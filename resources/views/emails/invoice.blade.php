<html>
    <head>
        <title></title>
        <style>
            #invoice-POS {
                box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
                padding: 12px;
                margin: 0 auto;
                width: 300px;
                background: #FFF
            }

            ::selection {background: #f31544; color: #FFF;}
            ::moz-selection {background: #f31544; color: #FFF;}
            h1{
                font-size: 1.5em;
                color: #222;
            }
            h2{font-size: 16px;}
            h3{
                font-size: 1.2em;
                font-weight: 300;
                line-height: 2em;
            }
            p{
                font-size: 16px;
                line-height: 1.2em;
            }

            #top, #mid,#bot{ /* Targets all id with 'col-' */
                border-bottom: 1px solid #EEE;
            }

            #top{min-height: 100px;}
            #mid{min-height: 80px;}
            #bot{ min-height: 50px; margin-top:12px}

            #top .logo{
                height: 60px;
                width: 60px;
                background: url({{url("/public/logo.png")}}) no-repeat;
                background-size: 60px 60px;
            }
            .info{
                display: block;
                margin-left: 0;
                font-size: 22px;
                text-align: center;
            }
            .title p{text-align: right;}
            table{
                width: 100%;
                border-collapse: collapse;
            }
            td{

            }
            .tabletitle{

                font-size: 16px;
                border-bottom: 1px dashed black;

            }
            .service{
                border-bottom: 1px dashed black;
            }

            .item{
                font-size: 23px;
            }
            .itemtext{
                margin: 4px;
            }

            #legalcopy{
                margin-top: 5px;
            }
            .dd{
                margin-top: 19px;
                padding-left: 14px;
            }
            .dd td{
                padding-top: 4px;
                padding-bottom: 1px;
                padding-left: 32px;
            }
            .service1{

                border-top: 1px dashed;
                font-size: 14px;
            }

        </style>
    </head>
    <body>
        <div id="invoice-POS">

            <center id="top">
                <div class="logo"></div>
                <div class="info">
                    <h2>{{$basic->title}}</h2>
                    <h2>Order Number : {{$order->serial}}</h2>
                </div><!--End Info-->
            </center><!--End InvoiceTop-->
            <div id="mid">
                <div class="info">
                    <h2>Customer Details</h2>
                    <p>
                        Name    : {{$order->customer->first_name}} {{$order->customer->last_name}}<br>
                        Phone   : {{$order->customer->phone}}<br>
                        Email   : {{$order->customer->email}}<br>
                    </p>
                </div>
            </div>

            <div id="bot">

                <div id="table">
                    <table>
                        <thead class="tabletitle">
                            <tr>
                                <td class="item"><h2>Diagnostic & Sell</h2></td>
                                <td class="item"><h2>Cost</h2></td>
                            </tr>
                        </thead>
                        @foreach($saleProducts as $diagnostic)
                            <tr class="service">
                                <td><p class="itemtext">{{$diagnostic->diagnostic->title}}</p></td>
                                <td><p class="itemtext">${{$diagnostic->diagnostic->diagnostic_fee}}</p></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="dd">
                    <table>
                        <tr class="service1">
                            <td>REPAIR TOTAL</td>
                            <td>${{$order->repair_cost}}</td>
                        </tr>
                        @if($order->discount == 0 )

                            @if($order->labor > 0)
                                <tr class="service1">
                                    <td>LABOR</td>
                                    <td>${{$order->labor}}</td>
                                </tr>
                            @endif

                        @else
                            @if($order->labor > 0)
                                <tr class="service1">
                                    <td>LABOR</td>
                                    <td>${{$order->labor}}</td>
                                </tr>
                            @endif
                            <tr class="service1">
                                <td>SUBTOTAL</td>
                                <td>${{$order->subtotal}}</td>
                            </tr>
                            <tr class="service1">
                                <td>DISCOUNT</td>
                                <td>${{$order->discount}}</td>
                            </tr>
                            <tr class="service1">
                                <td>TOTAL</td>
                                <td>${{$order->total}}</td>
                            </tr>
                            <tr class="service1">
                                <td>TAX</td>
                                <td>${{$order->tax}}</td>
                            </tr>
                        @endif
                        <tr class="service1">
                            <td>GRAND TOTAL</td>
                            <td>${{$order->grand_total}}</td>
                        </tr>
                        <tr class="service1">
                            <td>PAYMENT AMOUNT</td>
                            <td>${{$order->down_payment_diagnostic}}</td>
                        </tr>
                        <tr class="service1">
                            <td>TOTAL DUE</td>
                            <td>${{number_format((float)$pre , 2, '.', '')}}</td>
                        </tr>

                    </table>
                </div>

                <div id="mid">
                    <div class="info">
                        <hr>
                            <h2>Contact Info</h2>
                        <hr>
                        <p>
                            Email   : {{$basic->email}}<br>
                            Phone   : {{$basic->phone}}<br>
                            {{$basic->address}}<br>
                        </p>
                    </div>
                </div><!--End Invoice Mid-->
                <div id="legalcopy">
                    <p style="text-align: center"><strong class="text-center">Thank you for your order!</strong></p>
                </div>

            </div><!--End InvoiceBot-->
        </div><!--End Invoice-->
    </body>
</html>
