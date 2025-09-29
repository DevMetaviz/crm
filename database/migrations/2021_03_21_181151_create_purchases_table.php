<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

           $table->string('doc_no');
            $table->date('doc_date');
            
             $table->integer('grn_id')->nullable();
             $table->double('net_discount')->nullable();
             $table->double('gst_tax')->nullable();
             $table->double('net_tax')->nullable();
             $table->boolean('is_gst')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
