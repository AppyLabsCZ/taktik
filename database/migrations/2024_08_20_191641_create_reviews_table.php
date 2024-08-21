<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->text('body');
            $table->unsignedTinyInteger('rating')->nullable();

            // vytvoříme polymorfní vztah, morphs je zkrácený zápis pro vytvoření dvou sloupců, reviewable_id a reviewable_type,
            // reviewable_id obsahuje ID záznamu, ke kterému recenze patří. To může být ID knihy, autora, žánru.
            // reviewable_type obsahuje jméno třídy modelu, ke kterému recenze patří.
            // To může být cesta k třídám Book, Author, Genre, atd.
            $table->morphs('reviewable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
