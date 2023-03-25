<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalReps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_reps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->bigInteger('company_id')->unsigned();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_reps', function (Blueprint $table) {
            $table->dropForeign('medical_reps_company_id_foreign');    
        });
        Schema::dropIfExists('medical_reps');
    }
}
