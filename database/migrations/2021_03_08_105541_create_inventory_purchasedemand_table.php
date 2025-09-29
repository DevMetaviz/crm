<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryPurchasedemandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_purchasedemand', function (Blueprint $table) {
            $table->id();
            $table->integer('demand_id');
            $table->integer('item_id');
             $table->integer('color_id');
            $table->string('unit');
            $table->double('quantity');
            $table->integer('pack_size')->nullable();
            
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
        Schema::dropIfExists('inventory_purchasedemand');
    }
}
