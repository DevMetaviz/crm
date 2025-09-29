<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStdTableRowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('std_table_rows', function (Blueprint $table) {
            $table->id();
            $table->integer('table_id');
            $table->integer('table_column_id');
            $table->integer('std_id')->nullable();
            $table->integer('super_id')->nullable();
            $table->string('value')->nullable();
            $table->integer('sort_order');
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
        Schema::dropIfExists('std_table_rows');
    }
}
