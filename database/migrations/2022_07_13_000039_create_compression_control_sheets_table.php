<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompressionControlSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compression_control_sheets', function (Blueprint $table) {
            $table->id();

            $table->integer('compression_id');
            $table->date('date')->nullable();
             $table->time('time')->nullable();
             $table->double('num1')->nullable();
             $table->double('num2')->nullable();
             $table->double('num3')->nullable();
             $table->double('num4')->nullable();
             $table->double('num5')->nullable();
             $table->double('num6')->nullable();
             $table->double('num7')->nullable();
             $table->double('num8')->nullable();
             $table->double('num9')->nullable();
             $table->double('num10')->nullable();

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
        Schema::dropIfExists('compression_control_sheets');
    }
}
