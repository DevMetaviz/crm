<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->string('doc_no');
             $table->date('doc_date');
             $table->date('start_date');
             $table->date('end_date')->nullable();
            
             
            
             $table->integer('doctor_id');
             $table->double('investment_amount');
             $table->double('target_value');
             $table->text('remarks')->nullable();
            $table->boolean('activeness');
            $table->boolean('closed');
    
            
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
        Schema::dropIfExists('targets');
    }
}
