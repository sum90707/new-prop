<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('introduce', 1024);
            $table->integer('create_by')->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('paper_quesition', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('paper_id')->unsigned();
            $table->integer('quesition_id')->unsigned();
            $table->softDeletes();
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
        Schema::dropIfExists('papers');
        Schema::dropIfExists('paper_quesition');
    }
}
