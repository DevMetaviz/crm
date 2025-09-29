<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
             $table->string('name');
             $table->integer('account_id');
             $table->integer('mid_sale_account_id');
             $table->integer('so_id')->nullable();
             $table->string('contact')->nullable();
             $table->string('mobile')->nullable();
             $table->string('contact2')->nullable();
             $table->string('mobile2')->nullable();

            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('cnic')->nullable();
            $table->integer('customer_type_id')->nullable();
            $table->tinyInteger('status');
            $table->string('cnic')->nullable();
            $table->string('ntn')->nullable();
            $table->string('zip_code')->nullable();
            $table->text('address')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('region_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('territory_id')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
