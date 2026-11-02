<?php

namespace Database\Factories;

use App\Models\OrganizationStructure;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrganizationStructure>
 */
class OrganizationStructureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'position' => fake()->jobTitle(),
            'parent_id' => null,
            'order' => fake()->numberBetween(0, 20),
            'status' => 'published',
        ];
    }
}
