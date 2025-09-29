<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_product', function (Blueprint $table) {
            $table->id();
            $table->integer('plan_id');
            $table->integer('product_id');
            $table->integer('std_id');
            $table->string('unit');
            $table->integer('quantity');
            $table->string('pack_size')->nullable();
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
        Schema::dropIfExists('plan_product');
    }
}
