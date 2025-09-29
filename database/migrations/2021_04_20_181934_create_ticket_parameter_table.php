<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketParameterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_parameter', function (Blueprint $table) {
            $table->id();
            $table->integer('ticket_process_id');
             $table->integer('parameter_id');
             $table->string('parameter_name')->nullable();
             $table->string('identity')->nullable();
             $table->string('type')->nullable();
             $table->string('formula')->nullable();
            $table->integer('sort_order');
            $table->string('value')->nullable();
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
        Schema::dropIfExists('ticket_parameter');
    }
}
