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
            $table->ulid('id')->primary();
            $table->timestamps();

            $table->string('title')->index();

            $table->string('series')
                ->nullable()
                ->index();

            $table->unsignedBigInteger('series_index')
                ->nullable()
                ->index();

            $table->string('author_surname')
                ->nullable()
                ->index();

            $table->string('author_forename')
                ->nullable()
                ->index();

            $table->string('co_author')
                ->nullable()
                ->index();

            $table->string('genre')
                ->nullable()
                ->index();

            $table->string('edition')
                ->nullable()
                ->index();

            $table->foreignUlid('shelf_id')
                ->constrained()
                ->cascadeOnDelete();
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
