<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjustmentItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjustment_item', function (Blueprint $table) {
            $table->id();
            $table->integer('adjustment_id');
            $table->integer('item_id');
            $table->integer('stock_id')->nullable();
            $table->string('type');
            $table->string('unit');
            $table->double('qty');
            $table->integer('pack_size');
            $table->double('rate');
            
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
        Schema::dropIfExists('adjustment_item');
    }
}
