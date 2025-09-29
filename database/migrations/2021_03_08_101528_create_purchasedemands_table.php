<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasedemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasedemands', function (Blueprint $table) {
            $table->id();
            $table->string('doc_no');
            $table->date('doc_date');
            $table->date('required_date')->nullable();
            $table->string('posted');
            $table->boolean('is_approved')->nullable();
        
            $table->integer('vendor_id')->nullable();
          

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
        Schema::dropIfExists('purchasedemands');
    }
}
