<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
        
            $table->string('application_no');
            $table->integer('employee_id');
            $table->integer('leave_type_id');
            $table->date('application_date');
             $table->date('from_date');
              $table->date('to_date');
            $table->string('status');
            $table->string('type')->nullable();
            $table->integer('paid_days')->nullable();
            $table->string('reason')->nullable();
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
        Schema::dropIfExists('leaves');
    }
}
