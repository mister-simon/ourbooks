<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Shelf;
use App\Models\User;
use Illuminate\Support\Str;
use League\Csv\Reader;

final class CsvImporter
{
    protected $attributeMap = [
        'Author Surname' => 'author_surname',
        'Author Forename' => 'author_forename',
        'Order' => 'series_index',
        'Book Title' => 'title',
        'Genre' => 'genre',
        'Edition' => 'edition',
        'Co Author' => 'co_author',
    ];

    protected $fillable;

    protected $reader;

    protected $headers;

    protected $users;

    public function __construct(
        string $path,
        protected ?Shelf $shelf = null
    ) {
        $this->fillable = (new Book)->getFillable();

        $this->reader = Reader::createFromPath($path, 'r')
            ->setHeaderOffset(0);

        $this->headers = $this->getHeaders();
        $this->users = $this->getUsers();
    }

    public function import($count = INF)
    {
        if ($this->users->isEmpty()) {
            return;
        }

        $this->shelf = $this->addUsersToShelf();

        foreach ($this->reader->getRecords() as $i => $record) {
            if ($i > $count) {
                break;
            }

            $data = $this->normaliseRecord($record);

            $book = $this->addBook($data);

            foreach ($this->users as $user) {
                $this->addBookUser($user, $book, $data);
            }
        }
    }

    protected function getHeaders()
    {
        // Parse out the headers
        return collect($this->reader->getHeader())
            ->transform(
                fn ($header) => str($header)
                    ->trim()
                    ->snake()
                    ->toString()
            );
    }

    protected function getUsers()
    {
        // Generate users from "read", "rating", and "comments" columns, splitting for email on a "|" char
        $userEmails = $this->headers
            ->filter(fn ($header) => Str::startsWith($header, 'read|') || Str::startsWith($header, 'rating|') || Str::startsWith($header, 'comments|'))
            ->transform(fn ($header) => Str::after($header, '|'))
            ->unique();

        return User::whereIn('email', $userEmails)->get();
    }

    protected function addUsersToShelf()
    {
        $shelf = $this->shelf;

        if ($shelf === null) {
            // Create a shelf + add the users to it
            $shelf = Shelf::create([
                'title' => 'Our Books',
            ]);
        }

        $shelf
            ->users()
            ->syncWithoutDetaching($this->users->modelKeys());

        return $shelf;
    }

    protected function normaliseRecord($record)
    {
        // Transform the data + create books
        // Trim header + values
        // Convert empty strings to nullables
        $data = collect($record)
            ->mapWithKeys(
                fn ($value, $header) => [
                    $this->attributeMap[trim($header)] ?? trim($header) => trim($value),
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

        return $data;
    }

    protected function addBook($data): Book
    {
        return $this->shelf
            ->books()
            ->create(
                $data->only($this->fillable)->all()
            );
    }

    protected function addBookUser(User $user, Book $book, $data)
    {
        $bookUser = collect($data)
            ->only([
                "read|{$user->email}",
                "rating|{$user->email}",
                "comments|{$user->email}",
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
