<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTblColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_tbl_columns', function (Blueprint $table) {
            $table->id();
            //$table->integer('ticket_id');
              //$table->integer('table_column_id');
            $table->integer('ticket_table_id');
            $table->integer('table_col_id');
             $table->string('heading')->nullable();
             $table->string('type')->nullable();

             $table->string('footer_type');
             $table->string('footer_text')->nullable();

              
              $table->integer('sort_order')->nullable();
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
        Schema::dropIfExists('ticket_tbl_columns');
    }
}
