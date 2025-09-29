<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryRequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_requisition', function (Blueprint $table) {
            $table->id();
             $table->integer('requisition_id');
            $table->integer('item_id');
            $table->integer('stage_id')->nullable();
            $table->string('unit');
            $table->double('quantity');
            $table->integer('pack_size')->nullable();
            $table->double('approved_qty')->nullable();
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
        Schema::dropIfExists('inventory_requisition');
    }
}
