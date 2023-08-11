<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use URL;
use Illuminate\Support\Str;

class PaymentController extends Controller
{

    private $base_url;
    public function __construct()
    {
        // Sandbox
        $this->base_url = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta';
        // Live
        //$this->base_url = 'https://tokenized.pay.bka.sh/v1.2.0-beta';
    }

    public function authHeaders(){
        return array(
            'Content-Type:application/json',
            'Authorization:' .$this->grant(),
            'X-APP-Key:'.env('BKASH_CHECKOUT_URL_APP_KEY')
        );
    }

    public function createPayment(Request $request)
    {


        session([
            'trip_id' => $request->trip_id,
            'totalTicket' => $request->totalTicket,
            'fare_amount' => $request->fare_amount,
            'from_id' => $request->from_id,
            'to_id' => $request->to_id,
        ]);



        $header =$this->authHeaders();

        $website_url = URL::to("/");

        $body_data = array(
            'mode' => '0011',
            'payerReference' => ' ',
            'callbackURL' => $website_url.'/admin/bkash/callback',
            'amount' => $request->fare_amount ? $request->fare_amount : 10,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => "Inv".Str::random(8) // you can pass here OrderID
        );
        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/create',$header,'POST',$body_data_json);

        return redirect((json_decode($response)->bkashURL));
    }


    public function grant()
    {
        $header = array(
            'Content-Type:application/json',
            'username:'.env('BKASH_CHECKOUT_URL_USER_NAME'),
            'password:'.env('BKASH_CHECKOUT_URL_PASSWORD')
        );
        $header_data_json=json_encode($header);

        $body_data = array('app_key'=> env('BKASH_CHECKOUT_URL_APP_KEY'), 'app_secret'=>env('BKASH_CHECKOUT_URL_APP_SECRET'));
        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/token/grant',$header,'POST',$body_data_json);

        $token = json_decode($response)->id_token;

        return $token;
    }

    public function curlWithBody($url,$header,$method,$body_data_json){
        $curl = curl_init($this->base_url.$url);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_POSTFIELDS, $body_data_json);
        curl_setopt($curl,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function callback(Request $request)
    {
        $allRequest = $request->all();

        dd($allRequest);

        if(isset($allRequest['status']) && $allRequest['status'] == 'failure'){
            return view('CheckoutURL.fail')->with([
                'response' => 'Payment Failure'
            ]);

        }else if(isset($allRequest['status']) && $allRequest['status'] == 'cancel'){
            return view('CheckoutURL.fail')->with([
                'response' => 'Payment Cancell'
            ]);

        }else{

            $response = $this->executePayment($allRequest['paymentID']);

            $arr = json_decode($response,true);

            if(array_key_exists("statusCode",$arr) && $arr['statusCode'] != '0000'){
                return view('CheckoutURL.fail')->with([
                    'response' => $arr['statusMessage'],
                ]);
            }else if(array_key_exists("message",$arr)){
                // if execute api failed to response
                sleep(1);
                $query = $this->queryPayment($allRequest['paymentID']);
                return view('CheckoutURL.success')->with([
                    'response' => $query
                ]);
            }

            return view('CheckoutURL.success')->with([
                'response' => $response
            ]);

        }

    }
}
