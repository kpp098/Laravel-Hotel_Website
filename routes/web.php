<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\InstamojoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;




Route::view("/", 'home')->middleware('login');
Route::view("email", "auth.email-verify")->name("email");
route::get('/pay/now', [PaymentController::class, 'instamojopayment']);
route::get('payment/success', [PaymentController::class, 'success']);
route::get('confirm_success', [ShipmentController::class, 'sendonline'])->name('confirm_success');
Route::post('/email/confirm', [HomeController::class, 'verification_Otp'])->name('email/confirm');
Route::post("/logged", [AdminController::class, 'login'])->name('logged');
Route::get("/", 'App\Http\Controllers\HomeController@redirects')->middleware('login')->name('home');
Route::get("/", 'App\Http\Controllers\HomeController@index')->middleware('login')->name('home');
Route::get('resend', [HomeController::class, 'resend'])->name('resend');
Route::post("/register/confirm", [HomeController::class, 'register'])->name('register/confirm');
Route::get("/redirects", [HomeController::class, 'redirects'])->name('redirects');

Route::get('/menu', [MenuController::class, 'menu'])->name('menu');

Route::get('/trace-my-order', [ShipmentController::class, 'trace'])->name('trace-my-order');

Route::get('/my-order', [ShipmentController::class, 'my_order'])->name('my-order');


Route::get("/rate/{id}", [HomeController::class, 'rate'])->name('rate');


Route::get("/top/rated", [HomeController::class, 'top_rated'])->name('top/rated');



Route::get("edit/rate/{id}", [HomeController::class, 'edit_rate'])->name('edit/rate');



Route::post("coupon/apply", [ShipmentController::class, 'coupon_apply'])->name('coupon/apply');





Route::get("delete/rate", [HomeController::class, 'delete_rate'])->name('delete/rate');



Route::get("/rate/confirm/{value}", [HomeController::class, 'store_rate'])->name('rate.confirm');


Route::get("/cart", [CartController::class, 'index'])->name('cart');


Route::post('/menu/{product}', [CartController::class, 'store'])->name('cart.store');
Route::post('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/mails/shipped/{total}', [ShipmentController::class, 'place_order'])->name('mails.shipped');
Route::post('/confirm_place_order/{total}', [ShipmentController::class, 'send'])->name('confirm_place_order');

Route::post('/checkout/{total}', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/reserve/confirm', [HomeController::class, 'reservation_confirm'])->name('reserve.confirm');

Route::post('/trace/confirm', [ShipmentController::class, 'trace_confirm'])->name('trace.confirm');
Route::view('Server', "errors/502");


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});



Route::get('/verifyAdd', [PaymentController::class, 'verifyadd'])->name('verifyAdd');



// Payment Routes for instamojo
Route::post('/instamojo/payments', [PaymentController::class, 'instamojopayment'])->name('/instamojo/payment');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('/payment/success');
// Route::post('/instamojo/payments', [InstamojoController::class, 'instamojopayment'])->name('/instamojo/payment');





// Admin start Route


Route::get('/admin/home', [AdminController::class, 'home'])->name('/admin/home');

Route::get('/admin/food-menu', [AdminController::class, 'food_menu'])->name('/admin/food-menu');

Route::get('/orders/process', [AdminController::class, 'orders_process'])->name('/orders/process');
Route::get('/orders/cancel', [AdminController::class, 'orders_cancel'])->name('/orders/cancel');

Route::get('/add/menu', [AdminController::class, 'add_menu'])->name('/add/menu');
Route::get('/add/chef', [AdminController::class, 'add_chef'])->name('/add/chef');

Route::get('/admin/chefs', [AdminController::class, 'chefs'])->name('/admin/chefs');




Route::get('/admin/orders-incomplete', [AdminController::class, 'order_incomplete'])->name('/admin/orders-incomplete');
Route::get('/orders-complete', [AdminController::class, 'order_complete'])->name('/orders-complete');
Route::get('/admin/reservation', [AdminController::class, 'reservation'])->name('/admin/reservation');
Route::get('/admin/coupon', [AdminController::class, 'coupon_show'])->name('/admin/coupon');
Route::get('/admin/show', [AdminController::class, 'admin_show'])->name('/admin/show');
Route::get('/customer', [AdminController::class, 'user_show'])->name('/customer');
Route::get('/admin/charge', [AdminController::class, 'charge'])->name('/admin/charge');
Route::get('/admin/banner/all', [AdminController::class, 'banner'])->name('/admin/banner/all');
Route::get('/admin/customize', [AdminController::class, 'customize'])->name('/admin/cutomize');
Route::get('/admin/add/banner', [AdminController::class, 'banner_add'])->name('/admin/add/banner');
Route::get('/customize/add', [AdminController::class, 'add_template'])->name('/customize/add');
Route::post('/menu/add/process', [AdminController::class, 'menu_add_process'])->name('/menu/add/process');
Route::post('/chef/add/process', [AdminController::class, 'chef_add_process'])->name('/chef/add/process');


Route::get('/menu/delete/{id}', [AdminController::class, 'menu_delete_process'])->name('/menu/delete');
Route::get('/chef/delete/{id}', [AdminController::class, 'chef_delete_process'])->name('/chef/delete');


Route::get('/menu/edit/{id}', [AdminController::class, 'menu_edit'])->name('/menu/edit');
Route::get('/chef/edit/{id}', [AdminController::class, 'chef_edit'])->name('/chef/edit');

Route::post('/menu/edit/process/{id}', [AdminController::class, 'menu_edit_process'])->name('/menu/edit/process');
Route::post('/edit/chef/process/{id}', [AdminController::class, 'chef_edit_process'])->name('/edit/chef/process');
Route::post('/invoice/approve/{id}', [AdminController::class, 'invoice_approve'])->name('/invoice/approve');
Route::get('/invoice/details/{id}', [AdminController::class, 'invoice_details'])->name('invoice/details');
Route::get('/invoice/cancel-order/{id}', [AdminController::class, 'invoice_cancel'])->name('/invoice/cancel-order');


Route::get('/invoice/complete/{id}', [AdminController::class, 'invoice_complete'])->name('invoice/complete');

Route::get('/order/location', [AdminController::class, 'order_location'])->name('/order/location');
Route::post('/invoice/location/edit', [AdminController::class, 'edit_order_location'])->name('/invoice/location/edit');
Route::get('/delivery-boy', [AdminController::class, 'delivery_boy'])->name('/delivery-boy');


Route::get('/admin-add', [AdminController::class, 'add_admin'])->name('/admin-add');
Route::get('/add/delivery_boy', [AdminController::class, 'add_delivery_boy'])->name('/add/delivery_boy');
Route::post('/admin-add-process', [AdminController::class, 'add_admin_process'])->name('/admin-add-process');
Route::get('/admin/delete/{id}', [AdminController::class, 'delete_admin'])->name('/admin/delete');
Route::get('/admin/edit/{id}', [AdminController::class, 'edit_admin'])->name('/admin/edit');
Route::post('/admin-edit-process/{id}', [AdminController::class, 'edit_admin_process'])->name('/admin-edit-process');
Route::post('/add-delivery-boy-process', [AdminController::class, 'add_delivery_boy_process'])->name('/add-delivery-boy-process');
Route::get('/delivery_boy/delete/{id}', [AdminController::class, 'delete_delivery_boy'])->name('/delivery_boy/delete');
Route::get('/delivery_boy/edit/{id}', [AdminController::class, 'edit_delivery_boy'])->name('/delivery_boy/edit');
Route::post('/edit_delivery_boy_process/{id}', [AdminController::class, 'edit_delivery_boy_process'])->name('/edit_delivery_boy_process');
Route::post('/banner/add/process', [AdminController::class, 'banner_add_process'])->name('/banner/add/process');
Route::get('/admin/banner/edit/{id}', [AdminController::class, 'banner_edit'])->name('/admin/banner/edit');
Route::post('/banner/edit/process/{id}', [AdminController::class, 'banner_edit_process'])->name('/banner/edit/process');
Route::get('/admin/banner/delete/{id}', [AdminController::class, 'banner_delete_process'])->name('/admin/banner/delete');
Route::get('/add/coupon', [AdminController::class, 'add_coupon'])->name('/add/coupon');
Route::post('/coupon-add-process', [AdminController::class, 'add_coupon_process'])->name('/coupon-add-process');
Route::get('/admin/coupon/delete/{id}', [AdminController::class, 'delete_coupon'])->name('/admin/coupon/delete');
Route::get('/admin/coupon/edit/{id}', [AdminController::class, 'edit_coupon'])->name('/admin/coupon/edit');
Route::post('/coupon-edit-process/{id}', [AdminController::class, 'edit_coupon_process'])->name('/coupon-edit-process');
Route::get('/add/charge', [AdminController::class, 'add_charge'])->name('/add/charge');
Route::post('/charge-add-process', [AdminController::class, 'add_charge_process'])->name('/charge-add-process');
Route::get('/admin/charge/delete/{id}', [AdminController::class, 'delete_charge'])->name('/admin/charge/delete');
Route::get('/admin/charge/edit/{id}', [AdminController::class, 'edit_charge'])->name('/admin/edit/delete');
Route::post('/charge-edit-process/{id}', [AdminController::class, 'edit_charge_process'])->name('/charge-edit-process');
Route::get('/customize/edit', [AdminController::class, 'customize_edit'])->name('/customize/edit');
Route::post('/customize_edit_process', [AdminController::class, 'edit_customize_process'])->name('/customize_edit_process');
