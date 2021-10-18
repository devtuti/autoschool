<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TestAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('a_id');
            $table->unsignedBigInteger('t_q_id');
            $table->string('answer', 255);
            $table->enum('correct_answer', [0,1])->default(0);
            $table->softDeletes();

            $table->foreign('t_q_id')
                  ->references('id')
                  ->on('test_questions')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('test_answers');
    }
}
