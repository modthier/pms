<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returned_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stock_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->integer('quantity_returned');
            $table->timestamps();

            $table->foreign('stock_id')->references('id')->on('stock')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('returned_items');
    }
}
