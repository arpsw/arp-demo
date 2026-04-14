<?php

namespace Modules\SFD\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SFD\Enums\ManufacturingOrderPriority;
use Modules\SFD\Enums\ManufacturingOrderStatus;
use Modules\SFD\Models\SfdBillOfMaterial;
use Modules\SFD\Models\SfdManufacturingOrder;
use Modules\SFD\Models\SfdProduct;

class SfdManufacturingOrderFactory extends Factory
{
    protected $model = SfdManufacturingOrder::class;

    public function definition(): array
    {
        return [
            'reference' => 'MO-'.fake()->unique()->numerify('####'),
            'product_id' => SfdProduct::factory(),
            'bom_id' => SfdBillOfMaterial::factory(),
            'quantity' => fake()->numberBetween(1, 20),
            'status' => ManufacturingOrderStatus::Draft,
            'priority' => ManufacturingOrderPriority::Normal,
            'scheduled_date' => fake()->optional()->dateTimeBetween('now', '+2 months'),
            'deadline' => fake()->optional()->dateTimeBetween('+1 month', '+3 months'),
            'notes' => null,
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn () => [
            'status' => ManufacturingOrderStatus::Confirmed,
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn () => [
            'status' => ManufacturingOrderStatus::InProgress,
        ]);
    }

    public function done(): static
    {
        return $this->state(fn () => [
            'status' => ManufacturingOrderStatus::Done,
            'completed_at' => now(),
        ]);
    }
}
