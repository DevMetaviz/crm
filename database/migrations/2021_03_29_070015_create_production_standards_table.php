<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionStandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_standards', function (Blueprint $table) {
            $table->id();
            $table->string('std_no');
            $table->string('std_name');
             $table->string('master_article_id');
             $table->integer('procedure_id')->nullable();
           $table->integer('batch_size');
            $table->string('activeness');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('production_standards');
    }
}
