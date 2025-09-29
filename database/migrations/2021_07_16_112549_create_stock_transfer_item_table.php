<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTransferItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transfer_item', function (Blueprint $table) {
            $table->id();
             $table->integer('transfer_id');
            $table->integer('item_id');
            $table->integer('challan_id')->nullable();
            $table->string('unit');
            $table->double('qty');
            $table->integer('pack_size');
            $table->double('mrp')->nullable();
             $table->string('batch_no')->nullable();
            $table->date('expiry_date')->nullable();

            $table->string('from_business_type')->nullable();
            $table->string('from_discount_type')->nullable();
            $table->double('from_discount_factor')->nullable();
           $table->double('from_tax')->nullable();

           $table->string('to_business_type')->nullable();
            $table->string('to_discount_type')->nullable();
            $table->double('to_discount_factor')->nullable();
           $table->double('to_tax')->nullable();

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
        Schema::dropIfExists('stock_transfer_item');
    }
}
