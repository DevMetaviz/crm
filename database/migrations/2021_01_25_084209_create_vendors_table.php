<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('vendor_type_id');
             $table->integer('account_id');
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            
            $table->string('bank1')->nullable();
            $table->string('account_title1')->nullable();
            $table->string('account_no1')->nullable();
            $table->string('bank2')->nullable();
            $table->string('account_title2')->nullable();
            $table->string('account_no2')->nullable();

            $table->string('address')->nullable();
            $table->string('sort_order')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('cnic')->nullable();
            $table->string('ntn_number')->nullable();
            $table->string('salestax_num')->nullable();
            $table->string('comment')->nullable();
       

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
        Schema::dropIfExists('vendors');
    }
}
