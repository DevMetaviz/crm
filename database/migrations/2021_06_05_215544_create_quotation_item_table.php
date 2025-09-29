<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_item', function (Blueprint $table) {
            $table->id();
            $table->integer('quotation_id');
            $table->integer('item_id');
        
            $table->string('unit');
            $table->double('qty');
            $table->integer('pack_size');
            $table->double('mrp')->nullable();
            $table->string('batch_no')->nullable();

            $table->string('business_type')->nullable();

            $table->date('expiry_date')->nullable();
            $table->string('discount_type')->nullable();
            $table->double('discount_factor')->nullable();
           $table->double('tax')->nullable();
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
        Schema::dropIfExists('quotation_item');
    }
}
