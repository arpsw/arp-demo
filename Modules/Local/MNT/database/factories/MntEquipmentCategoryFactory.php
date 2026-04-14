<?php

namespace Modules\MNT\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\MNT\Models\MntEquipmentCategory;

class MntEquipmentCategoryFactory extends Factory
{
    protected $model = MntEquipmentCategory::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'color' => fake()->optional()->hexColor(),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
