<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'author' => $this->faker->sentence(),
            'genre' => $this->faker->sentence(),
            'isbn' => $this->faker->randomDigit(),
            'image' => $this->faker->imageUrl(640,480),
            'published' => $this->faker->date(),
            'publisher' => $this->faker->sentence(),
            'description' => $this->faker->text()
        ];
    }
}
