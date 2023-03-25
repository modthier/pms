<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentMethodIdToOrderRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_request', function (Blueprint $table) {
           $table->bigInteger('paymentMethod_id')->nullable()->unsigned();
           $table->foreign('paymentMethod_id')->references('id')->on('payment_methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_request', function (Blueprint $table) {
            //
        });
    }
}
