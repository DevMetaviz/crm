<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
              $table->string('doc_no');
            $table->date('doc_date');
            $table->integer('customer_id');
             $table->string('type');
            $table->double('gst')->nullable();
            $table->double('net_discount')->nullable();
            $table->string('net_discount_type')->nullable();
            $table->integer('currency_id');
            $table->double('cur_rate');

            $table->integer('shipment_port_id')->nullable();
            $table->integer('discharge_port_id')->nullable();
            $table->integer('packing_type_id')->nullable();
            $table->integer('freight_type_id')->nullable();
            $table->integer('transportation_id')->nullable();

            $table->boolean('activeness');
            $table->boolean('approved');
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
        Schema::dropIfExists('quotations');
    }
}
