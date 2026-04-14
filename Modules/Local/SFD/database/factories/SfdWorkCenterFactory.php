<?php

namespace Modules\SFD\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SFD\Models\SfdWorkCenter;

class SfdWorkCenterFactory extends Factory
{
    protected $model = SfdWorkCenter::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'code' => fake()->unique()->bothify('WC-????'),
            'capacity' => fake()->numberBetween(1, 3),
            'cost_per_hour' => fake()->randomFloat(2, 20, 80),
            'time_before_production' => fake()->randomElement([0, 5, 10, 15]),
            'time_after_production' => fake()->randomElement([0, 5, 10]),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
