<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_sales', function (Blueprint $table) {
            $table->id();
            $table->string('doc_no');
             $table->date('doc_date');
            $table->string('invoice_no')->nullable();
             
             $table->integer('point_id');
             $table->integer('distributor_id');
             $table->integer('salesman_id')->nullable();
             $table->integer('doctor_id')->nullable();

             $table->string('type');
             $table->double('sale_value')->nullable();

             $table->text('remarks')->nullable();
            $table->boolean('activeness');
    
            
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
        Schema::dropIfExists('point_sales');
    }
}
