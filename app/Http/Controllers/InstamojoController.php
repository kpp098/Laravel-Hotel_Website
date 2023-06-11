<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class InstamojoController extends Controller
{



    public function instamojopayment()
    {

        $products = Session::get('products');
        $invoice = Session::get('invoice');
        $total = Session::get('total');
        $extra_charge = Session::get('extra_charge');
        $discount_price = Session::get('discount_price');
        $without_discount_price = Session::get('without_discount_price');
        # CUSTOMER INFORMATION
        $post_data['cus_name'] = Auth::user()->name;
        $post_data['cus_email'] = Auth::user()->email;
        $post_data['ship_name'] = "Hotel_Century";
        $post_data['cus_phone'] = Auth::user()->phone;


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.instamojo.com/v2/gateway/orders/payment-request/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-Api-Key:test_ce051854cbee902ee7677fcc15e",
            "X-Auth-Token:test_6a5bc5614e1f4dde534779422bc"
        ));


        $payload = array(
            'purpose' => $post_data['ship_name'],
            'amount' => $total,
            'buyer_name' => $post_data['cus_name'],
            'email' => $post_data['cus_email'],
            'phone' => $post_data['cus_phone'],
            'redirect_url' => 'http://localhost:8000/instamojo_redirect',
            'send_email' => 'True',
            'webhook' => 'http://www.example.com/webhook/',
            'allow_repeated_payments' => 'False',
        );

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        return redirect($response->payment_request->longurl);
    }

    public function instamojo_redirect()
    {
        echo '<pre>';
        print_r($_GET);
    }
    public function verifyadd()
    {

        $total = Session::get('total');


        return view('exampleEasycheckout', compact('total'));
    }


    public function instamojoSuccess(Request $request)
    {
        // IF PAYMENT SUCCESS THEN YOU CAN APPLY YOUR CONDITION HERE
        if ('Noman' == 'success') {

            // THEN YOU CAN REDIRECT TO YOUR ROUTE

            Session::flash('successMsg', 'Payment has been Completed Successfully');

            return response()->json(['status' => true]);
        }

        Session::flash('error', 'Noman Error Message');

        return response()->json(['status' => false]);
    }
}
