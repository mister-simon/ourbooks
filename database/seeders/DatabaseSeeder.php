<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Helpers\ConsoleImportReporter;
use App\Models\Book;
use App\Models\Shelf;
use App\Models\User;
use App\Services\CsvImporter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Basic data seed
        $books = Book::factory()
            ->count(150);

        $shelves = Shelf::factory()
            ->has($books);

        User::factory()
            ->has($shelves)
            ->create(['email' => 'user@example.com']);

        // Import from csv
        $importCsv = database_path('seeders/import.csv');

        if (File::exists($importCsv)) {
            User::factory()
                ->create([
                    'email' => 'simon@example.com',
                    'name' => 'Simon',
                ]);

            User::factory()
                ->create([
                    'email' => 'tone@example.com',
                    'name' => 'Tone',
                ]);

            (new CsvImporter(
                path: $importCsv,
                shelf: Shelf::factory()
                    ->create(['title' => 'Our Books'])
            ))
                ->setReporter(new ConsoleImportReporter($this->command))
                ->import();

            (new CsvImporter(
                path: $importCsv,
                shelf: Shelf::factory()
                    ->create(['title' => 'Our Books - 100'])
            ))
                ->setReporter(new ConsoleImportReporter($this->command))
                ->import(count: 100);
        }
    }
}
