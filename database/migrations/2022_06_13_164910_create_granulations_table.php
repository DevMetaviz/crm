<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGranulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('granulations', function (Blueprint $table) {
            $table->id();

            $table->integer('plan_id');
             $table->dateTime('grn_start');
             $table->dateTime('grn_comp');
             $table->text('lead_time');
             $table->string('temprature');
             $table->string('humidity');
             $table->time('sev_start');
             $table->time('sev_complete');
             $table->number('sev_num');
             $table->string('dry_time');
             $table->string('dry_temp');
             $table->time('mixing_start_time');
             $table->time('mixing_complete_time');

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
        Schema::dropIfExists('granulations');
    }
}
