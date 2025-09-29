<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_employee', function (Blueprint $table) {
            $table->id();
            $table->integer('salary_id');
            $table->integer('employee_id');
            
            $table->double('current_salary')->nullable();
            $table->double('attendance_days')->nullable();
            $table->double('late_coming_days')->nullable();
            $table->double('late_fine')->nullable();
            $table->double('overtime')->nullable();
            $table->double('overtime_amount')->nullable();
            $table->double('earned_salary')->nullable();
            $table->double('gross_salary')->nullable();
            $table->double('penality_charges')->nullable();
            $table->double('tax')->nullable();
            $table->double('net_salary')->nullable();
            $table->double('loan_deduction')->nullable();
            $table->double('payable_salary')->nullable();
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
        Schema::dropIfExists('salary_employee');
    }
}
