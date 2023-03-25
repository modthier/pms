<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stock_id')->unsigned();
            $table->bigInteger('order_request_id')->unsigned();
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->foreign('order_request_id')->references('id')->on('order_request')->onDelete('cascade');
            $table->foreign('stock_id')->references('id')->on('stock')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drug_orders', function (Blueprint $table) {
            $table->dropForeign('drug_orders_order_request_id_foreign');
            $table->dropForeign('drug_orders_stock_id_foreign');     
        });
        Schema::dropIfExists('drug_orders');
    }
}
