<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_item', function (Blueprint $table) {
            $table->id();
            $table->integer('challan_id');
            $table->integer('item_id');
            $table->integer('order_item_id')->nullable();
        
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
        Schema::dropIfExists('delivery_item');
    }
}
