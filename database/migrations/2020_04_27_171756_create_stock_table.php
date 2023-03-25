<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('drug_id')->unsigned();
            $table->string('barcode');
            $table->decimal('purchasing_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->integer('quantity_per_unit');
            $table->date('exp');
            $table->integer('count_per_unit');
            $table->integer('pst');
            $table->timestamps();

            $table->foreign('drug_id')->references('id')->on('drugs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock', function (Blueprint $table) {
            $table->dropForeign('stock_drug_id_foreign');    
        });
        Schema::dropIfExists('stock');
    }
}
