<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaseorders', function (Blueprint $table) {
            $table->id();
            $table->string('doc_no');
            $table->string('po_type')->nullable();
            $table->date('doc_date');
            $table->date('due_date')->nullable();
             $table->integer('purchasedemand_id')->nullable();
            $table->date('received_date')->nullable();
            $table->integer('shipped_via')->nullable();
            $table->string('fob_point')->nullable();
            $table->string('payment_type')->nullable();
            $table->integer('order_by')->nullable();
            $table->integer('approve_by')->nullable();
             $table->double('gst_tax')->nullable();
            $table->double('with_holding_tax')->nullable();
            $table->string('posted');
            $table->string('dispatched_status')->nullable();
            $table->integer('vendor_id');
            $table->string('remarks')->nullable();
            $table->string('terms')->nullable();
             $table->string('payment_terms')->nullable();
              $table->string('delivery_terms')->nullable();
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
        Schema::dropIfExists('purchaseorders');
    }
}
