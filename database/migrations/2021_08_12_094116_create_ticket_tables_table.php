<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_tables', function (Blueprint $table) {
            $table->id();
            $table->integer('ticket_id');
              $table->integer('table_id');
            $table->string('name')->nullable();
             $table->string('identity')->nullable();
              $table->integer('ticket_process_id');
              $table->integer('no_of_rows')->nullable();
              $table->integer('sort_order')->nullable();
             $table->boolean('activeness');
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
        Schema::dropIfExists('ticket_tables');
    }
}
