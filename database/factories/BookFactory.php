<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Book;
use App\Models\Collector;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
final class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'type' => fake()->randomElement(Book::getTypes()),
            'collector_id' => Collector::factory(),
        ];
    }
}
