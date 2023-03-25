<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->string('trade_name');
            $table->string('generic_name');
            $table->bigInteger('item_type_id')->unsigned();
            $table->bigInteger('unit_id')->unsigned();
            $table->bigInteger('company_id')->unsigned();
            $table->bigInteger('md_rep_id')->unsigned()->nullable();
            $table->timestamps();
            
           

            $table->foreign('item_type_id')->references('id')->on('drug_item_types')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('drug_units')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('md_rep_id')->references('id')->on('medical_reps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->dropForeign('drugs_item_type_id_foreign');
            $table->dropForeign('drugs_unit_id_foreign');
            $table->dropForeign('drugs_company_id_foreign');        
        });
        Schema::dropIfExists('drugs');
    }
}
