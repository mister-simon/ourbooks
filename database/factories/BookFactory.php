<?php

namespace Database\Factories;

use App\Enums\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'series' => fake()->words(asText: true),
            'series_index' => fake()->numberBetween(0, 50),
            'author_surname' => fake()->lastName(),
            'author_forename' => fake()->firstName(),
            'title' => str(fake()->words(asText: true))->title(),
            'genre' => fake()->randomElement(Genre::cases())->value,
            'edition' => fake()->randomElement([
                'Hardback',
                'Paperback',
                'Hardback Clothbound',
                'Hardback Leatherbound',
                'Paperback Gifted',
                'Paperback Annotated',
                'Paperback Boxset',
                'SF Master Works - Gifted',
            ]),
            'co_author' => fake()->optional()->name(),
        ];
    }
}
