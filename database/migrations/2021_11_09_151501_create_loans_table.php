<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            $table->string('doc_no');
             $table->date('request_date');
              $table->string('loan_type');
              $table->double('loan_amount');
              $table->integer('employee_id')->nullable();
               $table->text('emp_remarks')->nullable();
               $table->integer('activeness');
                $table->integer('is_paid')->nullable();
                $table->double('approved_amount')->nullable();
                $table->integer('authorized_by')->nullable();
                $table->text('remarks')->nullable();
             $table->boolean('status')->nullable();

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
        Schema::dropIfExists('loans');
    }
}
