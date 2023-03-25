<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceOrderRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_order_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_request_id')->constrained('order_request');
            $table->foreignId('insurance_company_id')
                    ->constrained('insurance_companies');
            $table->double('deduct_value');
            $table->integer('deduct_rate');
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
        Schema::dropIfExists('order_request_patient');
    }
}
