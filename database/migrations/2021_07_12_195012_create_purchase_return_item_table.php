<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReturnItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_return_item', function (Blueprint $table) {
            $table->id();
             
            $table->integer('return_id');
            $table->integer('item_id');
            $table->string('grn_no')->nullable();
            $table->string('unit');
             $table->double('p_qty');
            $table->double('quantity');
            //$table->integer('rec_quantity')->nullable();
            $table->integer('pack_size')->nullable();
            //$table->integer('rej_quantity')->nullable();
            $table->double('current_rate')->nullable();
            $table->double('pack_rate')->nullable();
            $table->double('discount')->nullable();
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
        Schema::dropIfExists('purchase_return_item');
    }
}
