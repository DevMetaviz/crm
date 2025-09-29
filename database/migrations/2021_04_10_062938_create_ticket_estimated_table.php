<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketEstimatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_estimated', function (Blueprint $table) {
            $table->id();
            $table->integer('ticket_id');
            $table->integer('item_id');

            $table->string('type')->nullable();
            $table->boolean('is_mf');
            $table->string('assay')->nullable();
            $table->string('grn_no')->nullable();
            $table->string('qc_no')->nullable();
            $table->integer('stage_id')->nullable();
            $table->string('unit');
            $table->double('quantity');
             $table->double('std_qty')->nullable();
            $table->string('pack_size')->nullable();
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
        Schema::dropIfExists('ticket_estimated');
    }
}
