<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_company_id')
                    ->constrained('insurance_companies');
            $table->date('date_from');
            $table->date('date_to');
            $table->double('mount_due');
            $table->double('amount_paid')->default(0);
            $table->string('year');
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
        Schema::dropIfExists('insurance_invoices');
    }
}
