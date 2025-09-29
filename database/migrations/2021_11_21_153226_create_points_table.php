<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->string('name');
             $table->integer('distributor_id');
             $table->integer('salesman_id')->nullable();
             $table->integer('doctor_id')->nullable();
             $table->string('contact')->nullable();
             $table->string('mobile')->nullable();
             $table->string('contact2')->nullable();
             $table->string('mobile2')->nullable();

            $table->string('phone')->nullable();
            $table->string('email')->nullable();
           
            $table->boolean('activeness');
    
            $table->text('address')->nullable();
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
        Schema::dropIfExists('points');
    }
}
