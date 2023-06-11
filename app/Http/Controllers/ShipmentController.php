<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use App\Mail\OrderShipped;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use PDF;
use QrCode;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;




class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::all();
        return view("cart", compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Cart::all();

        Mail::to($request->user())->send(new OrderShipped($order));
    }


    //  ***************** place Order ***********

    public function place_order($total)
    {

        return view('place_order', compact('total'));
    }


    // ********************** Send ******

    public function send(Request $request, $total)
    {

        $data = array();

        $invoice = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 8);

        $order_list = DB::table('carts')->where('product_order', 'Order placed')->get();



        $data['shipping_address'] = $request->address;
        $data['product_order'] = "Order Placed";
        $data['invoice_no'] = $invoice;
        $data['pay_method'] = "Cash On Delivery";
        $data['delivery_time'] = "3 hours";
        $data['purchase_date'] = date("Y-m-d");





        $products = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->get();
        $without_discount_price  = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->sum('subtotal');
        $carts_amount = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->count();
        $extra_charge = DB::table('charges')->get();
        $total_extra_charge = DB::table('charges')->sum('price');
        $coupon_code = NULL;
        $discount_price = Session::get('discount_price');


        $without_discount_price = $without_discount_price + $total_extra_charge;

        $total = $without_discount_price - $discount_price;




        $carts = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->update($data);

        $details = [
            'title' => 'Mail from Hotel_Century',
            'body' => 'Your order have been Placed Successfully.Your order Invoice no - ' . $invoice . 'ok',
        ];




        $data["title"] = "Mail From Hotel_Century";
        $data["body"] = "Your reservation have been Placed Successfully";











        Session::put('products', $products);
        Session::put('invoice', $invoice);
        Session::put('total', $total);
        Session::put('extra_charge', $extra_charge);
        Session::put('discount_price', $discount_price);
        Session::put('without_discount_price', $without_discount_price);
        Session::put('date', date("Y-m-d"));


        if ($invoice == NULL) {

            $invoice = "Hotel_Century ";
        }




        $qrcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate('Hotel_Century  Verified'));
        $pdf = PDF::loadView('mails.PaymentMail', $data);

        Session::put('qrcode', $qrcode);



        if ($carts) {

            Mail::send('mails.PaymentMail', $data, function ($message) use ($data, $pdf) {
                $message->to(Auth::user()->email, Auth::user()->email)
                    ->subject($data["title"])
                    ->attachData($pdf->output(), "Order Copy.pdf");
            });
        }


        return view('Confirm_order', compact('invoice', 'products', 'total'));
    }


    public function sendonline(Request $request)
    {
        $total = Session::get('total');
        $data = array();

        $invoice = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 8);

        $order_list = DB::table('carts')->where('product_order', 'Order placed')->get();



        $data['shipping_address'] = $request->address;
        $data['product_order'] = "Order Placed";
        $data['invoice_no'] = $invoice;
        $data['pay_method'] = " Online Payment";
        $data['delivery_time'] = "3 hours";
        $data['purchase_date'] = date("Y-m-d");


        Session::put('status', $data['pay_method']);

        $products = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->get();
        $without_discount_price  = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->sum('subtotal');
        $carts_amount = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->count();
        $extra_charge = DB::table('charges')->get();
        $total_extra_charge = DB::table('charges')->sum('price');
        $coupon_code = NULL;
        $discount_price = Session::get('discount_price');


        $without_discount_price = $without_discount_price + $total_extra_charge;

        $total = $without_discount_price - $discount_price;




        $carts = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->update($data);

        $details = [
            'title' => 'Mail from Hotel_Century',
            'body' => 'Your order have been Placed Successfully.Your order Invoice no - ' . $invoice . 'ok',
        ];




        $data["title"] = "Mail From Hotel_Century";
        $data["body"] = "Your reservation have been Placed Successfully";











        Session::put('products', $products);
        Session::put('invoice', $invoice);
        Session::put('total', $total);
        Session::put('extra_charge', $extra_charge);
        Session::put('discount_price', $discount_price);
        Session::put('without_discount_price', $without_discount_price);
        Session::put('date', date("Y-m-d"));


        if ($invoice == NULL) {

            $invoice = "Hotel_Century ";
        }




        $qrcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate('Hotel_Century  Verified'));
        $pdf = PDF::loadView('mails.Online_payment', $data);

        Session::put('qrcode', $qrcode);



        if ($carts) {

            Mail::send('mails.Online_payment', $data, function ($message) use ($data, $pdf) {
                $message->to(Auth::user()->email, Auth::user()->email)
                    ->subject($data["title"])
                    ->attachData($pdf->output(), "Order Copy.pdf");
            });
        }


        return view('Online_Confirm_Order', compact('invoice', 'products', 'total'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //  *********************** update ***************
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    // ******************* my Order ***************
    public function my_order()
    {

        if (!Auth::user()) {

            return redirect()->route('login');
        }

        $carts = Cart::all()->where('user_id', Auth::user()->id);
        $total_price = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', '!=', 'no')->sum('subtotal');
        return view("my_order", compact('carts', 'total_price'));
    }

    // ********************* Trace ********************
    public function trace()
    {

        if (!Auth::user()) {

            return redirect()->route('login');
        }


        $carts = Cart::all()->where('user_id', Auth::user()->id)->where('product_order', 'Order placed');
        $total_price = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->sum('subtotal');
        return view("trace", compact('carts', 'total_price'));
    }

    // ******************************* Trace Confirm ***********************


    public function trace_confirm(Request $req)
    {

        if (!Auth::user()) {

            return redirect()->route('login');
        }
        $carts = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', '!=', 'no')->where('invoice_no', $req->invoice)->count();

        if ($carts == 0) {

            session()->flash('wrong', 'Invaild Invoice no !');
            return back();
        }

        // if ($req->phone != Auth::user()->phone) {

        //     session()->flash('wrong', 'Wrong phone no !');
        //     return back();
        // }


        $carts = Cart::all()->where('user_id', Auth::user()->id)->where('product_order', '!=', 'no')->where('invoice_no', $req->invoice);
        $total_price = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', '!=', 'no')->where('invoice_no', $req->invoice)->sum('subtotal');
        $carts_amount = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', '!=', 'no')->where('invoice_no', $req->invoice)->count();
        $without_discount_price = $total_price;
        $discount_price = 0;
        $coupon_code = NULL;

        if ($carts_amount > 0) {
            foreach ($carts as $cart) {

                $coupon_code = $cart->coupon_id;
            }
        }

        if ($coupon_code != NULL) {


            $total_price = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', '!=', 'no')->where('invoice_no', $req->invoice)->sum('subtotal');


            $coupon_code_price = DB::table('coupons')->where('code', $coupon_code)->value('percentage');

            $coupon_code_price = floor($coupon_code_price);

            $discount_price = (($total_price * $coupon_code_price) / 100);
            $discount_price = floor($discount_price);


            $total_price = $total_price - $discount_price;
        } else {

            $total_price = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', '!=', 'no')->where('invoice_no', $req->invoice)->sum('subtotal');
        }
        $extra_charge = DB::table('charges')->get();
        $total_extra_charge = DB::table('charges')->sum('price');

        $total_price = $total_price + $total_extra_charge;
        $without_discount_price = $without_discount_price + $total_extra_charge;

        return view("trace_confirm", compact('carts', 'total_price', 'extra_charge', 'discount_price', 'without_discount_price'));
    }





    // ******************************************************coupan apply **********

    public function coupon_apply(Request $req)
    {


        $coupon_code = DB::table('coupons')->where('code', $req->code)->count();

        if ($coupon_code == 0) {

            session()->flash('wrong', 'Wrong Coupon Code !');
            return back();
        }
        $validate = DB::table('coupons')->where('code', $req->code)->value('validate');

        $today = date("Y-m-d");

        if ($validate < $today) {

            session()->flash('wrong', 'Expire Validation Date !');
            return back();
        }

        $data = array();

        $data['coupon_id'] = $req->code;

        $update_coupon = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->update($data);

        if ($update_coupon) {



            return redirect('/cart');
        } else {

            session()->flash('wrong', 'Already applied this code !');
            return back();
        }
    }
}
