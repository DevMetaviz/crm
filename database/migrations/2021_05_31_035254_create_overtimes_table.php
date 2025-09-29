<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();
            $table->string('doc_no');
            $table->integer('employee_id');
            $table->date('overtime_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('total_time');
            $table->text('remarks')->nullable();
            $table->tinyInteger('activeness');
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
        Schema::dropIfExists('overtimes');
    }
}
