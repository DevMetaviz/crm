<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispensingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispensings', function (Blueprint $table) {
            $table->id();

             $table->integer('plan_id');
             $table->dateTime('dispense_start');
             $table->dateTime('dispense_comp');
             
             $table->string('temprature');
             $table->string('humidity');

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
        Schema::dropIfExists('dispensings');
    }
}
