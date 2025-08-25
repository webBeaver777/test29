<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarModel>
 */
class CarModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'brand_id' => Brand::factory(),
        ];
    }

    public function modelForBrand(string $name, int $brandId): static
    {
        return $this->state(fn () => [
            'name' => $name,
            'brand_id' => $brandId,
        ]);
    }
}
