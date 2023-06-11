<?php

namespace App\Components;

use App\Components\InstamojoPG\Instamojo;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Exception;

require __DIR__ . DIRECTORY_SEPARATOR . 'InstamojoPG/Utilities.php';

class InstamojoApp
{
    private  $amount;
    private $customer_add;
    private $customer_mobile;
    private $customer_email;
    private $customer_name;
    private $redirect_url;

    public function __construct($customer_name, $amount, $customer_mobile, $customer_email)
    {

        $this->amount = Session::get('total');
        $this->customer_name = Auth::user()->name;
        $this->customer_email = Auth::user()->email;
        $this->customer_mobile = Auth::user()->phone;
        $this->redirect_url = url('/payment/success');
    }
    public function client()
    {
        $authType = 'app';
        $initParam = [
            "client_id" => config('services.instamojo.client_id'),
            "client_secret" => config('services.instamojo.client_secret'),
        ];
        return Instamojo::init($authType, $initParam, true);
    }



    public function pay($params)
    {
        $api = $this->client();
        try {
            $response = $api->createPaymentRequest(array(
                "purpose" => $params['company_name'],
                "amount" =>  $this->amount,
                "buyer_name" =>  $this->customer_name,
                "email" =>  $this->customer_email,
                "redirect_url" =>  $this->redirect_url,
            ));
            return $response['longurl'];
        } catch (Exception $e) {
            print('Error: ' . $e->getMessage());
        }
    }
}
