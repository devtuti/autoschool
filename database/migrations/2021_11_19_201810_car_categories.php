<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CarCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_categories', function (Blueprint $table) {
            $table->id();
            $table->string('cat_name', 155);
            $table->string('slug', 155);
            $table->unsignedBigInteger('sub_id')->nullable();
            $table->enum('status', [0, 1]);
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
        Schema::dropIfExists('car_categories');
    }
}
