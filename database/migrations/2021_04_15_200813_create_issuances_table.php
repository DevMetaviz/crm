<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issuances', function (Blueprint $table) {
            $table->id();
            $table->string('issuance_no');
            $table->date('issuance_date');
            $table->integer('requisition_id')->nullable();
            $table->date('requisition_date')->nullable();
            $table->integer('department_id')->nullable();
            $table->string('issued');
            $table->string('status');
            $table->string('batch_no')->nullable();
            $table->integer('ticket_id')->nullable();
            $table->integer('issued_by')->nullable();
            $table->integer('received_by')->nullable();
            $table->integer('receiving_department')->nullable();
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
        Schema::dropIfExists('issuances');
    }
}
