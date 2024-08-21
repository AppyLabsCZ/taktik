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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');

            // foreignId je zkrácený způsob, jak v Laravelu vytvořit cizí klíč,
            // v tomto případě metoda vytvoří sloupec UNSIGNED BIGINT


            // metoda constrained umožňuje Laravelu vytvořit omezení cizího klíče v databázi,
            // aniž byste museli explicitně definovat, ke kterým sloupcům je vázán
            $table->foreignId('author_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
