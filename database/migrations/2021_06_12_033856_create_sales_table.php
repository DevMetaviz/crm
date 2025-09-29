<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->date('invoice_date');
            $table->string('type');
            $table->integer('customer_id');
            $table->integer('challan_id')->nullable();
            $table->integer('salesman_id')->nullable();
            $table->double('net_discount')->nullable();
            $table->string('net_discount_type')->nullable();
            $table->double('gst')->nullable();

            $table->integer('currency_id');
            $table->double('cur_rate');

            $table->integer('shipment_port_id')->nullable();
            $table->integer('discharge_port_id')->nullable();
            $table->integer('packing_type_id')->nullable();
            $table->integer('freight_type_id')->nullable();
            $table->integer('transportation_id')->nullable();
            
            
            $table->boolean('activeness');
    
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
