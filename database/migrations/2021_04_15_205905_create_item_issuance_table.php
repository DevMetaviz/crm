<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemIssuanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_issuance', function (Blueprint $table) {
            $table->id();
             $table->integer('issuance_id');
            $table->integer('item_id');
            $table->integer('stock_id')->nullable();
            $table->string('qc_no')->nullable();
            $table->integer('stage_id')->nullable();
            $table->string('unit');
            $table->double('req_quantity')->nullable();
            $table->double('quantity');
            $table->string('pack_size')->nullable();
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
        Schema::dropIfExists('item_issuance');
    }
}
