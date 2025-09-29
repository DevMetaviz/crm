<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemProductionStandardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_production_standard', function (Blueprint $table) {
            $table->id();
            $table->integer('std_id');
            $table->integer('item_id');
            $table->string('type');
            $table->boolean('is_mf');
            $table->integer('stage_id')->nullable();
            $table->string('unit');
            $table->double('quantity');
            
            $table->integer('pack_size')->nullable();
            $table->integer('sort_order')->nullable();
            
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
        Schema::dropIfExists('item_production_standard');
    }
}
