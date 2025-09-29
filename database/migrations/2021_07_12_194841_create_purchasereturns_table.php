<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasereturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasereturns', function (Blueprint $table) {
            $table->id();
            $table->string('doc_no');
             $table->date('doc_date');
             $table->integer('purchase_id')->nullable();
             $table->double('net_discount')->nullable();
             $table->double('gst_tax')->nullable();
             $table->double('net_tax')->nullable();
            $table->boolean('posted');
            $table->integer('vendor_id')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('purchasereturns');
    }
}
