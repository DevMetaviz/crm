<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYieldDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yield_details', function (Blueprint $table) {
            $table->id();

            $table->integer('yield_id');
             $table->date('transfer_date');
             $table->string('unit');
             $table->double('qty');
             $table->double('pack_size');

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
        Schema::dropIfExists('yield_details');
    }
}
