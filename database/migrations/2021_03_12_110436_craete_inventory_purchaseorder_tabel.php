<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CraeteInventoryPurchaseorderTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_purchaseorder', function (Blueprint $table) {
            $table->id();
              $table->integer('order_id');
            $table->integer('item_id');
             $table->integer('color_id');
            $table->string('unit');
            $table->double('quantity');
            $table->integer('pack_size')->nullable();
            $table->double('unit_rate')->nullable();
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
        Schema::dropIfExists('inventory_purchaseorder');
    }
}
