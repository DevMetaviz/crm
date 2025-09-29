<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyAttendancesTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dailyattendances', function (Blueprint $table) {
            $table->id();
             
             $table->integer('employee_id');
            $table->string('name')->nullable();
            $table->string('no')->nullable();
            $table->date('date')->nullable();
        
            $table->string('status')->nullable();
           // $table->string('status')->nullable();
            //$table->string('status')->nullable();
            //$table->string('status')->nullable();
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
        Schema::dropIfExists('dailyattendances');
    }
}
