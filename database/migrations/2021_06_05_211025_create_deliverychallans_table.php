<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverychallansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverychallans', function (Blueprint $table) {
            $table->id();
              $table->string('doc_no');
            $table->date('challan_date');
            $table->integer('customer_id');
            $table->integer('order_id')->nullable();

            $table->integer('deliver_via')->nullable();
            $table->string('bilty_no')->nullable();
            $table->string('bilty_type')->nullable();
            
            $table->boolean('activeness');
            $table->boolean('delivered');
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
        Schema::dropIfExists('deliverychallans');
    }
}
