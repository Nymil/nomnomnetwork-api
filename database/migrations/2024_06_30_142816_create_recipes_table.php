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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->require();
            $table->string('creator_username')->require();
            $table->binary('image_url');
            $table->string('category')->nullable();
            $table->integer('calories')->require();
            $table->json('ingredients')->require();
            $table->string('instructions')->require();
            $table->timestamps();

            $table->foreign('creator_username')->references('username')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
