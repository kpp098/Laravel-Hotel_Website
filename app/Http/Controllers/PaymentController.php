<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Components\InstamojoApp;



class PaymentController extends Controller
{
    public function verifyadd()
    {

        $total = Session::get('total');


        return view('exampleEasycheckout', compact('total'));
    }


    function instamojopayment()
    {
        $amount = Session::get('total');
        $customer_name = Auth::user()->name;
        $customer_email = Auth::user()->email;
        $customer_mobile = Auth::user()->phone;
        $client = new InstamojoApp($customer_name, $amount, $customer_mobile, $customer_email);
        return redirect($client->pay(['company_name' => 'Hotel_Century']));
    }

    function success(request $request)
    {

        $total = Session::get('total');
        Session::put('transaction', $request->payment_id);
        return Redirect('confirm_success');
    }
}
