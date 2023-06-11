<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->decimal("product_id", 6, 0);
            $table->string("name", 255);
            $table->decimal("price", 6, 2);
            $table->decimal("quantity", 6, 0);
            $table->decimal("subtotal", 6, 2);
            $table->string('invoice_no', 250);
            $table->string('user_id', 250);
            $table->string('product_order', 250);
            $table->string('pay_method', 100);
            $table->string('shipping_address', 5000);
            $table->string('delivery_time', 120);
            $table->string('purchase_date', 250);
            $table->string('coupon_date', 250);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
