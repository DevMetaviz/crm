<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQaSamplingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qa_samplings', function (Blueprint $table) {
            $table->id();
                  
            $table->string('sampling_no');
            $table->integer('qa_samplable_id');
            $table->string('qa_samplable_type');
            $table->string('type')->nullable();
             $table->double('sample_qty');
             $table->double('total_qty')->nullable();
            $table->date('sampling_date');
            $table->time('sampling_time');
            $table->integer('item_id');
            $table->string('grn_no')->nullable();
            $table->integer('plan_id')->nullable();
            $table->string('process')->nullable();
            $table->date('received_date')->nullable();
            $table->time('received_time')->nullable();
            $table->tinyInteger('is_received')->nullable();
            $table->tinyInteger('verified')->nullable();
           
            $table->string('remarks')->nullable();
            
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
        Schema::dropIfExists('qa_samplings');
    }
}
