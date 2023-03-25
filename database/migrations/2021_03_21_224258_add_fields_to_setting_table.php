<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting', function (Blueprint $table) {
            $table->string('address');
            $table->string('tel');
            $table->string('nif')->comment('Commercial Number');
            $table->string('rc')->comment('Fiscal Identification Number');
            $table->tinyInteger('vat')->default(0)->comment('Subject to VAT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setting', function (Blueprint $table) {
            //
        });
    }
}
