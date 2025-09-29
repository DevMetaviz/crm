<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompressionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compressions', function (Blueprint $table) {
            $table->id();

             $table->integer('plan_id');
             $table->dateTime('start_date');
             $table->dateTime('comp_date');
             $table->text('lead_time');
             $table->string('temprature');
             $table->string('humidity');
             $table->double('granules_weight');
             $table->string('punch_size');
             $table->double('initial_weight');
             $table->double('final_weight');
             $table->string('recommended_weight');
             $table->string('hardness_remarks');
             $table->string('thickness_remarks');

             $table->date('weight_date')->nullable();
             $table->time('weight_start_time')->nullable();
             $table->time('weight_end_time')->nullable();
             $table->string('weight_tab_size')->nullable();
             $table->string('weight_limit')->nullable();

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
        Schema::dropIfExists('compressions');
    }
}
