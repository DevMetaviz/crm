<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrnInventoryTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grn_inventory', function (Blueprint $table) {
            $table->id();
            $table->integer('grn_id');
            $table->integer('item_id');
            $table->string('unit');
            $table->double('quantity');
            $table->double('rec_quantity')->nullable();
            $table->integer('pack_size')->nullable();
            $table->string('grn_no')->nullable();
            $table->int('no_of_container')->nullable();
            $table->string('type_of_container')->nullable();
            $table->integer('origin_id')->nullable();
            $table->string('batch_no')->nullable();
            $table->double('mrp')->nullable();
            $table->date('mfg_date')->nullable();
            $table->date('exp_date')->nullable();
            $table->double('approved_qty')->nullable();
            $table->smallInteger('is_active')->nullable();
            $table->tinyInteger('is_sampled')->nullable();
            $table->text('remarks')->nullable();
            $table->double('rej_quantity')->nullable();
            
            
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
        Schema::dropIfExists('grn_inventory');
    }
}
