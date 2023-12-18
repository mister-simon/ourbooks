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
        Schema::create('book_user', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->foreignUlid('book_id')
                ->constrained('books')
                ->cascadeOnDelete();

            $table->foreignUlid('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->char('read', 1)
                ->nullable()
                ->index();

            $table->decimal('rating', 4, 2, true)
                ->nullable()
                ->index();

            $table->text('comments')
                ->nullable();

            $table->timestamps();

            $table->unique(['book_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_user');
    }
};
