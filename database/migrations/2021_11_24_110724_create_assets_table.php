<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
             $table->string('number');
            
             $table->integer('category_id');
            
             $table->integer('type_id');
             $table->string('brand')->nullable();

            $table->string('model')->nullable();
            $table->string('serial_no')->nullable();

            $table->integer('condition_id')->nullable();
            
             $table->integer('status_id')->nullable();
             $table->integer('location_id')->nullable();

            $table->string('manufacture')->nullable();
            $table->integer('vendor_id');
            $table->date('purchase_date');
            $table->double('purchase_price');
            $table->double('current_value')->nullable();
            $table->date('warranty_expire')->nullable();

             $table->double('wh_tax')->nullable();

           
            $table->text('description')->nullable();
            $table->boolean('activeness');

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
        Schema::dropIfExists('assets');
    }
}
