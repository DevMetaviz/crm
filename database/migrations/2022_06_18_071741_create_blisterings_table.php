<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlisteringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blisterings', function (Blueprint $table) {
            $table->id();
             $table->integer('plan_id');
             $table->dateTime('start_date');
             $table->dateTime('comp_date');
             $table->text('lead_time');
             $table->string('temprature');
             $table->string('humidity');
             $table->string('empty_result');
             $table->string('filled_result');
             $table->string('machine');
             $table->string('machine_id');
             $table->dateTime('embossing_date');
             $table->string('embossing_operator');
             $table->string('embossing_stamp');
             $table->string('packaging_supervisor');
             $table->string('qa_inspector');
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
        Schema::dropIfExists('blisterings');
    }
}
