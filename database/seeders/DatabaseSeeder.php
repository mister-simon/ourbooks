<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\Shelf;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()
            ->has(
                Shelf::factory()
                    ->has(
                        Book::factory()
                            ->count(150)
                    )
            )
            ->create([
                'email' => 'arst@arst.arst',
            ]);
    }
}
