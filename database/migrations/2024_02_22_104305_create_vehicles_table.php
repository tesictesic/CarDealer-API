<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable(true);
            $table->unsignedInteger('horsepower');
            $table->unsignedInteger('seats');
            $table->text('description');
            $table->unsignedInteger('year');
            $table->string('image');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('car_body_id');
            $table->unsignedBigInteger('fuel_id');
            $table->unsignedBigInteger('color_id');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('car_body_id')->references('id')->on('car_body');
            $table->foreign('fuel_id')->references('id')->on('fuels');
            $table->foreign('color_id')->references('id')->on('colors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
