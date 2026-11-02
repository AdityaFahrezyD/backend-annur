<?php

namespace Database\Factories;

use App\Models\ExtracurricularImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExtracurricularImage>
 */
class ExtracurricularImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'path' => fake()->url(),
            'alt_text' => fake()->sentence(4),
            'order' => fake()->numberBetween(0, 10),
        ];
    }
}
