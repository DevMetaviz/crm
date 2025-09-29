<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_returns', function (Blueprint $table) {
            $table->id();

            $table->string('doc_no');
            $table->date('doc_date');
            $table->integer('issuance_id')->nullable();
            
            $table->integer('department_id')->nullable();
        
            $table->string('returned');
    
            $table->integer('plan_id')->nullable();
            // $table->integer('issued_by')->nullable();
            // $table->integer('received_by')->nullable();
            // $table->integer('receiving_department')->nullable();
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
        Schema::dropIfExists('issue_returns');
    }
}
