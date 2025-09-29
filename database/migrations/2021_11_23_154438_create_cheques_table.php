<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChequesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheques', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_id');
          

            $table->string('cheque_number')->unique();
            $table->date('cheque_date');
            $table->decimal('amount', 12, 2);
          
            $table->tinyInteger('status')->default('0');
            $table->date('received_date')->nullable();
            
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

        
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();

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
        Schema::dropIfExists('cheques');
    }
}
