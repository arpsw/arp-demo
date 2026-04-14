<?php

namespace Modules\SFD\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SFD\Enums\ProductType;
use Modules\SFD\Models\SfdProduct;

class SfdProductFactory extends Factory
{
    protected $model = SfdProduct::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'sku' => fake()->unique()->bothify('??-###'),
            'type' => ProductType::RawMaterial,
            'description' => fake()->optional()->sentence(),
            'unit_cost' => fake()->randomFloat(2, 1, 500),
            'image_url' => null,
        ];
    }

    public function finished(): static
    {
        return $this->state(fn () => [
            'type' => ProductType::Finished,
        ]);
    }

    public function subAssembly(): static
    {
        return $this->state(fn () => [
            'type' => ProductType::SubAssembly,
        ]);
    }

    public function rawMaterial(): static
    {
        return $this->state(fn () => [
            'type' => ProductType::RawMaterial,
        ]);
    }
}
