<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGatepassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gatepasses', function (Blueprint $table) {
            $table->id();
            $table->string('doc_no');
            $table->date('doc_date');
             $table->string('type')->nullable();
             $table->boolean('returnable')->nullable();
             $table->boolean('activeness');
            $table->string('name');
             $table->string('vehicle')->nullable();
             $table->time('time_out')->nullable();
             $table->time('time_in')->nullable();
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
        Schema::dropIfExists('gatepasses');
    }
}
