<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Likes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('share_id')->null();
            $table->unsignedBigInteger('comment_id')->null();
            $table->enum('share_liked', [0,1])->default(0);
            $table->enum('comment_liked', [0,1])->default(0);
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->foreign('share_id')
            ->references('id')
            ->on('shares')
            ->onDelete('cascade');

            $table->foreign('comment_id')
            ->references('id')
            ->on('comments')
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
        Schema::dropIfExists('likes');
    }
}
