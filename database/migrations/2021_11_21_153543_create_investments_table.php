<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->string('doc_no');
             $table->date('investment_date');
            
             $table->integer('invested_through')->nullable();
             $table->text('remarks')->nullable();
             $table->integer('point_id');
             $table->string('type');

            $table->double('amount');
            $table->text('comment')->nullable();
           
            $table->boolean('activeness');
    
            $table->boolean('is_invested');
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
        Schema::dropIfExists('investments');
    }
}
