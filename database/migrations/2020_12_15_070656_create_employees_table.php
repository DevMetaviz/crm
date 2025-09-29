<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('employee_code')->nullable();
            $table->string('zk_id')->nullable();
            $table->integer('super_employee')->nullable();
            $table->string('father_husband_name')->nullable();
            $table->date('dateOfBirth')->nullable();
            $table->string('cnic')->nullable();
            $table->string('cnic_place')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('qualification')->nullable();
            $table->string('religion')->nullable();
            $table->string('refference')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->date('domicile')->nullable();
            $table->date('joining_date')->nullable();
            $table->date('leaving_date')->nullable();
            $table->string('activeness');
             $table->boolean('attendance_required')->nullable();
            $table->string('employee_type')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('designation_id')->nullable();
            $table->boolean('is_so')->nullable();
            $table->string('shift_id')->nullable();
            $table->string('allowed_leave')->nullable();
            $table->string('comment')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('salary')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
