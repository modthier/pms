<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_price', 10, 2);
            $table->integer('quantity');
            $table->bigInteger('stock_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('purchase_order', function (Blueprint $table) {
            $table->dropForeign('purchase_order_user_id_foreign');
            $table->dropForeign('purchase_order_stock_id_foreign');    
        });
        Schema::dropIfExists('purchase_order');
    }
}
