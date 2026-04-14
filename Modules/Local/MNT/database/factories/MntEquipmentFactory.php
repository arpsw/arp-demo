<?php

namespace Modules\MNT\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\MNT\Enums\EquipmentStatus;
use Modules\MNT\Models\MntEquipment;
use Modules\MNT\Models\MntEquipmentCategory;

class MntEquipmentFactory extends Factory
{
    protected $model = MntEquipment::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'serial_number' => fake()->unique()->bothify('SN-####-????'),
            'category_id' => MntEquipmentCategory::factory(),
            'status' => EquipmentStatus::Operational,
            'location' => fake()->optional()->word(),
            'model' => fake()->optional()->bothify('Model-####'),
            'manufacturer' => fake()->optional()->company(),
            'purchase_date' => fake()->optional()->dateTimeBetween('-5 years', '-1 year'),
            'cost' => fake()->optional()->randomFloat(2, 500, 50000),
        ];
    }

    public function operational(): static
    {
        return $this->state(fn () => [
            'status' => EquipmentStatus::Operational,
        ]);
    }

    public function underMaintenance(): static
    {
        return $this->state(fn () => [
            'status' => EquipmentStatus::Maintenance,
        ]);
    }
}
