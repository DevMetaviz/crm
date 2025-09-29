<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coatings', function (Blueprint $table) {
            $table->id();

             $table->integer('plan_id');
             $table->dateTime('start_date');
             $table->dateTime('comp_date');
             $table->text('lead_time');
             $table->string('temprature');
             $table->string('humidity');
             $table->double('mix_time');
             $table->string('inlet_temperature');
             $table->double('bed_temperature');
             $table->double('outlet_temperature');
             $table->string('machine_speed');
             $table->string('distance_spray_gun');

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
        Schema::dropIfExists('coatings');
    }
}
