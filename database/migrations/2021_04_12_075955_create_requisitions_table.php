<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('requisition_no');
            $table->date('requisition_date');
            $table->integer('department_id')->nullable();
            $table->boolean('activeness');
            $table->integer('issued');
            $table->string('status');
            $table->integer('product_id')->nullable();
            $table->string('batch_no')->nullable();
            $table->integer('ticket_id')->nullable();
            $table->boolean('is_approved');
            $table->text('remarks')->nullable();
            $table->integer('request_by')->nullable();
            $table->integer('approved_by')->nullable();
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
        Schema::dropIfExists('requisitions');
    }
}
