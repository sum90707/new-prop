<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPaperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('introduce', 1024);
            $table->integer('paper_id')->unsigned();
            $table->integer('create_by')->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('user_quiz', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quiz_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->json('detail')->nullable()->default(null);
            $table->integer('score')->nullable()->default(null);
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
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('user_quiz');
    }
}
