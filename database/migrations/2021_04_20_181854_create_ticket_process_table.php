<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_process', function (Blueprint $table) {
            $table->id();
            $table->integer('ticket_id');
            $table->integer('process_id');
            $table->string('type');
            $table->integer('super_id');
            $table->string('process_name');
            $table->string('identity');
             $table->integer('sort_order');
            $table->string('qc_required');
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
        Schema::dropIfExists('ticket_process');
    }
}
