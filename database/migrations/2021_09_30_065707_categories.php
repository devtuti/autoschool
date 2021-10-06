<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Categories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('cat_name', 155);
            $table->string('slug', 155);
            $table->unsignedBigInteger('sub_id')->nullable();
            $table->enum('status', [0, 1]);
            $table->timestamps();

            /*$table->foreign('sub_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('cascade');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
