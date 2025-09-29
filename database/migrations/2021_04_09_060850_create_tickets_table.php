<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
             $table->string('ticket_no');
            $table->date('ticket_date');
            $table->string('batch_no');
            $table->integer('batch_size')->nullable();
            $table->integer('plan_id');
            $table->string('remarks')->nullable();
             $table->integer('inventory_id');
              $table->integer('quantity');
               $table->string('unit');
                $table->integer('pack_size');
                $table->double('mrp')->nullable();
                $table->date('mfg_date')->nullable();
                $table->date('exp_date')->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
