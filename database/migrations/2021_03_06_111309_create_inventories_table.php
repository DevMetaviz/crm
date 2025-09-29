<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('department_id');
            $table->string('type_id');
            $table->string('item_code');
            $table->string('item_name');
            $table->string('color_ids')->nullable();
            $table->string('packings')->nullable();
            $table->string('pack_size')->nullable();
            $table->double('pack_size_qty')->nullable();

            $table->tinyInteger('status');
            $table->string('manufactured_by')->nullable();
            $table->string('item_bar_code')->nullable();
            $table->string('generic')->nullable();
            $table->string('origin_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('unit_id')->nullable();
            $table->integer('small_unit_id')->nullable();
            $table->double('unit_rate')->nullable();
             $table->tinyInteger('is_manufactured')->nullable();
              $table->integer('procedure_id')->nullable();
              $table->integer('gtin_id')->nullable();
            $table->string('minimal')->nullable();
            $table->string('optimal')->nullable();
            $table->string('maximal')->nullable();
            $table->string('size_id')->nullable();
            $table->string('color_id')->nullable();
            $table->integer('stock_id')->nullable();
            $table->double('rate')->nullable();
            $table->double('purchase_price')->nullable();
            
        
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
        Schema::dropIfExists('inventories');
    }
}
