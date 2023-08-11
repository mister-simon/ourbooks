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
        Schema::create('books', function (Blueprint $table) {
            $table->ulid('id');
            $table->timestamps();

            $table->string('series');
            $table->unsignedBigInteger('series_index');

            $table->string('author_surname');
            $table->string('author_forename');

            $table->string('book_title');
            $table->string('genre');
            $table->string('edition');
            $table->string('co_author');

            $table->foreignUlid('shelf_id');
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
