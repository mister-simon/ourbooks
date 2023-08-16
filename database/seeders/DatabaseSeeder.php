<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\Shelf;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // CSV import
        $importCsv = database_path('seeders/import.csv');

        if (File::exists($importCsv)) {
            $user = User::factory()
                ->has(Shelf::factory(['title' => 'Our Shelf']))
                ->create([
                    'email' => 'simon@example.com',
                    'name' => 'Simon',
                ]);

            $shelf = $user->shelves->first();

            $reader = Reader::createFromPath($importCsv, 'r')
                ->setHeaderOffset(0);

            $attributeMap = [
                'Author Surname' => 'author_surname',
                'Author Forename' => 'author_forename',
                'Order' => 'series_index',
                'Book Title' => 'title',
                'Genre' => 'genre',
                'Edition' => 'edition',
                'Co Author' => 'co_author',
            ];

            foreach ($reader->getRecords() as $record) {
                $data = collect($record)
                    ->mapWithKeys(
                        fn ($value, $header) => [
                            $attributeMap[trim($header)] ?? trim($header) => trim($value),
                        ]
                    )
                    ->transform(
                        fn ($value, $attribute) => $attribute === 'series_index'
                            ? ($value === '' ? null : (int) $value)
                            : $value
                    )
                    ->all();

                $shelf->books()->create($data);
            }
        }

        // Basic data seed
        User::factory()
            ->has(
                Shelf::factory()
                    ->has(
                        Book::factory()
                            ->count(150)
                    )
            )
            ->create(['email' => 'test@example.com']);

    }
}
