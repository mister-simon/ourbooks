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

            $table->string('series')->index();
            $table->unsignedBigInteger('series_index')->index();

            $table->string('author_surname')->index();
            $table->string('author_forename')->index();

            $table->string('title')->index();
            $table->string('genre')->index();
            $table->string('edition')->index();
            $table->string('co_author')->index();

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
