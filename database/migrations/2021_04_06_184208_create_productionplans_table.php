<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productionplans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_no');
            $table->string('text');
            $table->date('plan_date');
            $table->date('start_date')->nullable();
            $table->date('complete_date')->nullable();
           $table->boolean('is_closed');
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
        Schema::dropIfExists('productionplans');
    }
}
