<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQcReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qc_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('qa_sample_id');         
            $table->string('qc_number');
            $table->string('testing_specs')->nullable();
            $table->date('tested_date');
            $table->date('released_date');
            $table->time('released_time');
            $table->date('retest_date')->nullable();
             
            $table->tinyInteger('is_active');
            $table->double('approved_qty');
            $table->tinyInteger('released')->coment('0=reject,1=released');
             $table->tinyInteger('status')->nullable()->coment('0=stock  updated, 1= stock not updated ');
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
        Schema::dropIfExists('qc_reports');
    }
}
