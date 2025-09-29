<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueReturnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_return_items', function (Blueprint $table) {
            $table->id();

             $table->integer('issue_return_id');
            $table->integer('item_id');
             $table->double('issue_item_id')->nullable();
            $table->string('grn_no')->nullable();
            $table->integer('stage_id')->nullable();
            $table->string('unit');
           
            $table->double('qty');
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
        Schema::dropIfExists('issue_return_items');
    }
}
