<?php

namespace Database\Factories;

use App\Models\Extracurricular;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Extracurricular>
 */
class ExtracurricularFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->words(2, true),
            'description' => fake()->paragraph(),
            'order' => fake()->numberBetween(0, 20),
            'status' => 'published',
        ];
    }
}
