<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_notes', function (Blueprint $table) {
            $table->id();
             $table->string('doc_no');
             $table->string('stock_id');
              $table->date('doc_date')->nullable();
              $table->integer('pack_size')->nullable();
               $table->string('unit');
            $table->double('qty');
            $table->boolean('returned')->nullable();
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
        Schema::dropIfExists('return_notes');
    }
}
