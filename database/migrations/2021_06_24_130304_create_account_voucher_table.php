<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_voucher', function (Blueprint $table) {
            $table->id();
            $table->integer('account_voucherable_id');
            $table->string('account_voucherable_type');
             $table->integer('voucher_id')->nullable();
            $table->integer('account_id');
            $table->integer('corporate_id')->nullable();
            $table->string('voucher_no')->nullable();
            $table->date('transection_date')->nullable();
            $table->string('remarks')->nullable();
             $table->string('cheque_no')->nullable();
             $table->string('cheque_date')->nullable();
             $table->double('debit');
            $table->double('credit');
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
        Schema::dropIfExists('account_voucher');
    }
}
