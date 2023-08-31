<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\Shelf;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use League\Csv\Reader;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // CSV import
        $importCsv = database_path('seeders/import.csv');

        if (File::exists($importCsv)) {
            $this->importCsv($importCsv, limit: 100);
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

    /**
     * Imports data into the system based on a pretty specific data structure.
     * Roughly based on the google sheet previously used for tracking books.
     * See the example import.csv
     */
    protected function importCsv(string $path, int $limit = INF)
    {
        // Prepare reader
        $reader = Reader::createFromPath($path, 'r')
            ->setHeaderOffset(0);

        // Parse out the headers
        $headers = collect($reader->getHeader())
            ->transform(
                fn ($header) => str($header)
                    ->trim()
                    ->snake()
                    ->toString()
            );

        // Generate users from "read" and "rating" columns, splitting for email on a "|" char
        $users = $headers
            ->filter(fn ($header) => Str::startsWith($header, 'read|') || Str::startsWith($header, 'rating|'))
            ->transform(fn ($header) => Str::after($header, '|'))
            ->unique()
            ->map(
                fn ($email) => User::create([
                    'email' => $email,
                    'name' => Str::before($email, '@'),
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                ])
            );

        if ($users->isEmpty()) {
            $users->push(
                User::factory(['email' => 'user@example.com'])->create()
            );
        }

        // Create a shelf + add the users to it
        $shelf = Shelf::create([
            'title' => 'Our Books',
        ]);

        $shelf
            ->users()
            ->syncWithoutDetaching($users->pluck('id'));

        // Import the books and user ratings / read statuses
        $attributeMap = [
            'Author Surname' => 'author_surname',
            'Author Forename' => 'author_forename',
            'Order' => 'series_index',
            'Book Title' => 'title',
            'Genre' => 'genre',
            'Edition' => 'edition',
            'Co Author' => 'co_author',
        ];

        $bookFillable = (new Book)->getFillable();

        foreach ($reader->getRecords() as $i => $record) {
            if ($i > $limit) {
                break;
            }

            // Transform the data + create books
            // Trim header + values
            // Convert empty strings to nullables
            $data = collect($record)
                ->mapWithKeys(
                    fn ($value, $header) => [
                        $attributeMap[trim($header)] ?? trim($header) => trim($value),
                    ]
                )
                ->transform(
                    fn ($value) => $value === '' ? null : $value
                );

            // Normalise series index numeric, strip any non-nums
            $seriesIndex = $data['series_index'];

            if ($seriesIndex !== null && is_numeric($seriesIndex) === false) {
                $data['series_index'] = str($seriesIndex)
                    ->replaceMatches('/[^\d]/', '')
                    ->toInteger();
            }

            // Parse series names out of the title by splitting on a " | "
            // I.e. "Discworld | Hogfather"
            if (Str::contains($data['title'], ' | ')) {
                $data['series'] = Str::before($data['title'], ' | ');
                $data['title'] = Str::after($data['title'], ' | ');
            }

            /** @var \App\Models\Book */
            $book = $shelf
                ->books()
                ->create(
                    $data->only($bookFillable)->all()
                );

            // Parse out any book user data
            foreach ($users as $user) {
                $bookUser = collect($data)
                    ->only([
                        "read|{$user->email}",
                        "rating|{$user->email}",
                    ])
                    ->mapWithKeys(
                        fn ($val, $key) => [Str::before($key, '|') => $val]
                    );

                $book->users()
                    ->attach(
                        $user->id,
                        $bookUser->all(),
                        touch: false
                    );
            }
        }
    }
}
