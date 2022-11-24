<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KursQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kurs_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cat_id');
            $table->string('question_name', 200);
            $table->string('slug', 200);
            $table->longText('question');
            $table->string('photo', 155);
            $table->integer('variant_count');
            $table->enum('staus', [0,1])->default(0);
            $table->softDeletes();

            $table->foreign('cat_id')
                  ->references('id')
                  ->on('kurs_categories')
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
        Schema::dropIfExists('kurs_questions');
    }
}
