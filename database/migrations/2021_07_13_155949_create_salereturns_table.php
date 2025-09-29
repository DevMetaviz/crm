<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalereturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salereturns', function (Blueprint $table) {
            $table->id();
             $table->string('doc_no');
            $table->date('doc_date');
            $table->integer('customer_id');
            $table->integer('invoice_id')->nullable();
            
            $table->boolean('activeness');
    
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('salereturns');
    }
}
