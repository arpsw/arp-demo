<?php

namespace Modules\SFD\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SFD\Models\SfdBillOfMaterial;
use Modules\SFD\Models\SfdOperation;
use Modules\SFD\Models\SfdWorkCenter;

class SfdOperationFactory extends Factory
{
    protected $model = SfdOperation::class;

    public function definition(): array
    {
        return [
            'bom_id' => SfdBillOfMaterial::factory(),
            'work_center_id' => SfdWorkCenter::factory(),
            'name' => fake()->words(3, true),
            'duration_minutes' => fake()->randomElement([15, 30, 45, 60, 90, 120]),
            'description' => fake()->optional()->sentence(),
            'sort_order' => 0,
        ];
    }
}
