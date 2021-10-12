<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('appointment_id')->constrained();
            $table->foreignId('doctor_id')->constrained();
            $table->foreignId('prescription_id')->constrained();
            $table->text('description');
            $table->string('doctor_fee');
            $table->string('other_fee');
            $table->string('total');
            $table->string('discount')->nullable();
            $table->string('final_total');
            $table->string('payment_status');
            $table->foreignId('prepared_by')->references('id')->on('users');
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
        Schema::dropIfExists('invoices');
    }
}
