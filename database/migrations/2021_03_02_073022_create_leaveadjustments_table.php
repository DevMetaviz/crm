<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveadjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaveadjustments', function (Blueprint $table) {
            $table->id();
             $table->string('adjustment_num');
            $table->date('adjustment_date');
            $table->integer('employee_id');
            $table->integer('leave_type_id');
             $table->string('adjustment_month');
             $table->integer('adjust_days');
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('leaveadjustments');
    }
}
