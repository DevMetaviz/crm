<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penalities', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->nullable();
            $table->string('text');
            $table->string('amount')->nullable();
            $table->string('type')->nullable();
            $table->string('weight')->nullable();
            $table->string('remarks')->nullable();
            $table->string('month')->nullable();
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
        Schema::dropIfExists('penalities');
    }
}
