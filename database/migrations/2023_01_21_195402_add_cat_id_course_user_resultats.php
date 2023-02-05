<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCatIdCourseUserResultats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_user_resultats', function (Blueprint $table) {
            $table->unsignedBigInteger('cat_id');
            $table->foreign('cat_id')
            ->references('id')
            ->on('kurs_categories')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_user_resultats', function (Blueprint $table) {
            //
        });
    }
}
