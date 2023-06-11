<?php

namespace App\Http\Controllers;

// use App\Ma
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Nette\Utils\Floats;
use Throwable;

class HomeController extends Controller
{



    public function index()
    {
        try {

            $menu = Product::all();
            $breakfast = DB::table('products')->where('catagory')->orwhere('session', '=', 0)->get();
            $lunch = DB::table('products')->where('catagory')->orwhere('session', '=', 1)->get();
            $dinner = DB::table('products')->where('catagory')->orwhere('session', '=', 2)->get();
            $chefs = DB::table('chefs')->get();


            if (Auth::user()) {

                $cart_amount = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->count();
            } else {

                $cart_amount = 0;
            }

            $about_us = DB::table('about_us')->get();
            $banners = DB::table('banners')->get();


            return view("home", compact('menu',  'breakfast', 'lunch', 'dinner', 'chefs', 'cart_amount', 'banners', 'about_us'));
        } catch (Exception $e) {
            return redirect("Server");
        }
    }
    public function redirects()
    {


        if (!Auth::user()) {

            return redirect()->route('login');
        }


        $menu = DB::table('products')->where('catagory', 'regular')->get();

        $breakfast = DB::table('products')->where('catagory', 'special')->get();
        $lunch = DB::table('products')->where('catagory', 'special')->get();
        $dinner = DB::table('products')->where('catagory', 'special')->get();


        $chefs = DB::table('chefs')->get();


        if (Auth::user()) {

            $cart_amount = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'Order Placed')->count();
        } else {

            $cart_amount = 0;
        }



        $about_us = DB::table('about_us')->get();
        $banners = DB::table('banners')->get();


        $usertype = Auth::user()->usertype;
        if ($usertype != '0') {

            $pending_order = DB::table('carts')->where('product_order', 'Order Placed')->count();

            $processing_order = DB::table('carts')->where('product_order', 'approve')->count();

            $cancel_order = DB::table('carts')->where('product_order', 'cancel')->count();

            $complete_order = DB::table('carts')->where('product_order', 'delivered')->count();

            $total = DB::table('carts')->sum('subtotal');


            $cash_on_payment = DB::table('carts')->where('pay_method', 'Cash On Delivery')->sum('subtotal');


            $online_payment = $total - $cash_on_payment;


            $customer = DB::table('users')->where('usertype', '0')->count();


            $delivery_boy = DB::table('users')->where('usertype', '3')->count();


            $user = DB::table('users')->count();


            // $admin = $user - ($customer + $delivery_boy);

            $admin = DB::table('users')->where('usertype', '2')->count();
            $rates = DB::table('rates')->get();

            $product = array();


            foreach ($rates as $rate) {


                $product[$rate->product_id] = 0;
                $voter[$rate->product_id] = 0;
                $per_rate[$rate->product_id] = 0;
            }



            foreach ($rates as $rate) {


                $product[$rate->product_id] = $product[$rate->product_id] + $rate->star_value;


                $voter[$rate->product_id] = $voter[$rate->product_id] + 1;

                if ($voter[$rate->product_id] > 0) {

                    $per_rate[$rate->product_id] = $product[$rate->product_id] / $voter[$rate->product_id];
                } else {


                    $per_rate[$rate->product_id] = $product[$rate->product_id];
                }

                $per_rate[$rate->product_id] = number_format($per_rate[$rate->product_id], 1);
            }

            $copy_product = $per_rate;

            arsort($per_rate);

            $product_get = array();


            foreach ($per_rate as $prod) {

                $index_search = array_search($prod, $copy_product);

                $product_get = DB::table('products')->where('id', $index_search)->get();


                // return $product_get;
            }


            $carts = DB::table('carts')->where('product_order', '!=', 'no')->where('product_order', '!=', 'cancel')->get();

            $cart = array();


            foreach ($carts as $cart) {


                $product_cart[$cart->product_id] = 0;
            }



            foreach ($carts as $cart) {


                $product_cart[$cart->product_id] = $product_cart[$cart->product_id] + $cart->quantity;
            }

            $copy_cart = $product_cart;

            arsort($product_cart);



            return view('admin.dashboard', compact('pending_order', 'product_cart', 'copy_cart', 'total', 'copy_product', 'per_rate', 'product', 'cash_on_payment', 'online_payment', 'customer', 'delivery_boy', 'admin', 'processing_order', 'cancel_order', 'complete_order'));
        } else {

            return view("home", compact('menu', 'breakfast', 'lunch', 'dinner', 'chefs', 'cart_amount', 'about_us', 'banners'));
        }
    }


    public function reservation_confirm(Request $req)
    {

        if (Auth::user()) {


            $name = $req->name;
            $email = $req->email;
            $phone = $req->phone;

            $no_guest = $req->no_guest;
            $date = $req->date;
            $time = $req->time;

            $message = $req->message;


            $data = array();

            $data['name'] = $name;
            $data['email'] = $email;
            $data['no_guest'] = $no_guest;
            $data['phone'] = $phone;
            $data['date'] = $date;
            $data['message'] = $message;
            $data['invoice'] = Str::random(6);
            $invoice = $data['invoice'];
            $data['time'] = date('h:i a', strtotime($time));
            echo "<script>alert('If U Did't Arrive Within 15 Min After Reservation Time, Your Reservation Will Be Cancelled.')</script>";
            $check = DB::table('reservations')->where('email', '=', $data['email'])->first();

            if ($check == null) {
                $confirm_reservation = DB::table('reservations')->Insert($data);
            } else {
                $confirm_reservation = DB::table('reservations')->update($data);
            }

            if ($confirm_reservation) {
                Session::put('res_name', $name);
                Session::put('res_email', $email);
                Session::put('res_guest', $no_guest);
                Session::put('res_phone', $phone);
                Session::put('res_date', $date);
                Session::put('res_time', $time);
                Session::put('res_message', $message);
                Session::put('res_invoice', $invoice);





                $details = [
                    'title' => 'Mail About Reservation.',
                    'body' => 'Your reservation have been Placed Successfully'
                ];

                Mail::to(Auth::user()->email)->send(new \App\Mail\ReserveMail($details));
                if (Auth::user()->email !== $data['email']) {
                    Mail::to($data['email'])->send(new \App\Mail\ReserveMail($details));
                }
                $data["title"] = "From Hotel_Century";
                $data["body"] = "Your reservation have been Placed Successfully";



                $files = [];





                return view('Reserve_order', compact('invoice'));
            }
        } else {
            return redirect('/login');
        }
    }

    public function rate($id)
    {


        if (!Auth::user()) {

            return redirect()->route('login');
        }

        $already_rate = DB::table('rates')->where('product_id', $id)->where('user_id', Auth::user()->id)
            ->count();


        $find_rate = DB::table('rates')->where('product_id', $id)->where('user_id', Auth::user()->id)
            ->value('star_value');


        $products = DB::table('products')->where('id', $id)->first();


        $total_rate = DB::table('rates')->where('product_id', $id)
            ->sum('star_value');


        $total_voter = DB::table('rates')->where('product_id', $id)
            ->count();

        if ($total_voter > 0) {

            $per_rate = $total_rate / $total_voter;
        } else {

            $per_rate = 0;
        }

        $per_rate = number_format($per_rate, 1);




        if ($already_rate > 0) {


            return view('rate_view', compact('products', 'find_rate', 'already_rate', 'total_rate', 'total_voter', 'per_rate'));
        }




        return view('rate', compact('products', 'find_rate', 'already_rate', 'total_rate', 'total_voter', 'per_rate'));
    }

    public function store_rate($value)
    {


        $product_id = Session::get('product_id');




        $user_id = Auth::user()->id;


        $star_value = $value;




        $data = array();

        $data['user_id'] = $user_id;
        $data['product_id'] = $product_id;
        $data['star_value'] = $value;

        $rate = DB::table('rates')->where('product_id', $product_id)->where('user_id', $user_id)->count();


        if ($rate > 0) {

            $edit_rate = DB::table('rates')->where('product_id', $product_id)->where('user_id', $user_id)->update($data);
        } else {

            $add = DB::table('rates')->Insert($data);
        }


        return view('Place_rate');
    }


    public function delete_rate()
    {

        $product_id = Session::get('product_id');
        $user_id = Auth::user()->id;
        $rate = DB::table('rates')->where('product_id', $product_id)->where('user_id', $user_id)->delete();





        return view('delete_rate_confirm');
    }

    public function edit_rate($id)
    {


        if (!Auth::user()) {

            return redirect()->route('login');
        }




        $find_rate = DB::table('rates')->where('product_id', $id)->where('user_id', Auth::user()->id)
            ->value('star_value');


        $products = DB::table('products')->where('id', $id)->first();


        $total_rate = DB::table('rates')->where('product_id', $id)
            ->sum('star_value');


        $total_voter = DB::table('rates')->where('product_id', $id)
            ->count();

        if ($total_voter > 0) {

            $per_rate = $total_rate / $total_voter;
        } else {

            $per_rate = 0;
        }

        $per_rate = number_format($per_rate, 1);




        return view('rate', compact('products', 'find_rate', 'total_rate', 'total_voter', 'per_rate'));
    }
    public function top_rated()
    {

        $products = DB::table('rates')
            ->get();


        $data = array();


        foreach ($products as $product) {


            $data[$product->product_id] = 0;
        }




        $max_product = array();

        foreach ($products as $product) {


            $data[$product->product_id] = $data[$product->product_id] + $product->star_value;
        }

        rsort($data);



        dd($data);
    }
    public function register(Request $req)
    {

        $data = array();
        $data['name'] = $req->name;
        $data['phone'] = $req->phone;
        $data['email'] = $req->email;
        $data['password'] = Hash::make($req->password);


        $email = DB::table('users')->where('email', $req->email)->count();


        if ($email > 0) {

            session()->flash('wrong', 'Email already registered !');
            return back();
        }

        $phone = DB::table('users')->where('phone', $req->phone)->count();


        if ($phone > 0) {

            session()->flash('wrong', 'Phone already registered !');
            return back();
        }
        if (strlen($req->password) < 8) {

            session()->flash('wrong', 'Password lenght at least 8 words!');
            return back();
        }

        if ($req->password != $req->password_confirmation) {


            session()->flash('wrong', 'Password do not match !');
            return back();
        }

        Session::put('email', $data['email']);
        Session::put("data", $data);


        Session::put('name', $data['name']);

        $mail = [

            'title' => 'mail from Hotel_Century',
            'body' => 'this is demom mail',

        ];
        $otp = rand(1111, 99999);
        Cache::put('otp', $otp, 60 * 5);

        Mail::to($data['email'])->send(new \App\Mail\DemoMail($mail));

        return redirect('/email');
    }

    public function resend()
    {

        $data['email'] = Session::get('email');
        $mail = [

            'title' => 'mail from Hotel_Century',
            'body' => 'this is demom mail',

        ];
        $otp = rand(1111, 99999);
        Cache::put('otp', $otp, 60 * 5);

        $mail = Mail::to($data['email'])->send(new \App\Mail\DemoMail($mail));

        $resent = "Otp Sent Again Successfully";
        session()->flash('resent', $resent);

        return back();
    }

    public function verification_Otp(Request $req)
    {

        $emailotp = Cache::get('otp');
        $otp = $req->otp;

        if ($emailotp == $otp) {
            $data = Session::get('data');
            Session::forget('wrong');
            $insert = DB::table('users')->Insert($data);
            if ($insert == true) {
                $success = "You Have Successfully Registered";
                session()->put('statuss', $success);
                session()->forget('reset');
                return redirect('/redirects');
            } else {
                $error = "Your Data Is Not Saved ,Try Again Later";
            }
        } else {
            $error = "You Have Entered Wrong OTP";
            session()->flash('wrong', $error);
            return back();
        }
    }
}
