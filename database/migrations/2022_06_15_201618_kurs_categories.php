<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KursCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kurs_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kurs_id');
            $table->string('kcat_name', 155);
            $table->string('slug', 155);
            $table->unsignedBigInteger('sub_id')->nullable();
            $table->enum('status', [0, 1]);
            $table->softDeletes();

            $table->foreign('kurs_id')
            ->references('id')
            ->on('kurs')
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
        Schema::dropIfExists('kurs_categories');
    }
}
