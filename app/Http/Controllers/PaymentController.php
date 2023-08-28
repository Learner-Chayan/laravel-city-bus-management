<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use URL;
use App\Models\Ticket_sale;
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

    public function createPayment($fare_amount,$ticket_id)
    {

        session([
            'ticket_id' => $ticket_id
        ]);

        $header =$this->authHeaders();

        $website_url = URL::to("/");

        $body_data = array(
            'mode' => '0011',
            'payerReference' => ' ',
            'callbackURL' => $website_url.'/admin/bkash/callback',
            'amount' => $fare_amount ? $fare_amount : 20,
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

        $ticket_sale = Ticket_sale::where('id',session('ticket_id'));
        if($ticket_sale){
            if(isset($allRequest['status']) && $allRequest['status'] == 'failure'){
                //save payment fail
                $ticket_sale->update(
                    ['payment_by' => 'Payment failed']
                );
                return redirect('admin/purchase-history')->with('error', 'Payment failed but your ticket purchased successfully!!');

            }else if(isset($allRequest['status']) && $allRequest['status'] == 'cancel'){
                //save payment cancel
                $ticket_sale->update(
                    ['payment_by' => 'Payment canceled']
                );
                return redirect('admin/purchase-history')->with('message', 'Payment canceled but your ticket purchased successfully!!');
            }else{
                //save payment success
                $paymentID = $allRequest['paymentID'];
                $ticket_sale->update([
                    'payment_by' => 'Bkash',
                    'transaction_id' => $paymentID,
                    'status' => 1, // status 1 means ticket confirmed and paid.
                ]);

                return redirect('admin/purchase-history')->with('message', 'Payment success and your ticket purchased successfully!!');
            }
        }else{
            // ticket okay, but unkown about payment .
            return redirect('admin/purchase-history')->with('message', 'Your ticket purchased successfully!! If any wrong , contact with us');
        }

    }
}
