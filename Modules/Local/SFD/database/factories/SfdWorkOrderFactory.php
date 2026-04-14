<?php

namespace Modules\SFD\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SFD\Enums\WorkOrderStatus;
use Modules\SFD\Models\SfdManufacturingOrder;
use Modules\SFD\Models\SfdOperation;
use Modules\SFD\Models\SfdWorkCenter;
use Modules\SFD\Models\SfdWorkOrder;

class SfdWorkOrderFactory extends Factory
{
    protected $model = SfdWorkOrder::class;

    public function definition(): array
    {
        return [
            'manufacturing_order_id' => SfdManufacturingOrder::factory(),
            'operation_id' => SfdOperation::factory(),
            'work_center_id' => SfdWorkCenter::factory(),
            'name' => fake()->words(3, true),
            'status' => WorkOrderStatus::Pending,
            'expected_duration' => fake()->randomElement([30, 45, 60, 90, 120]),
            'actual_duration' => null,
            'started_at' => null,
            'completed_at' => null,
            'assigned_to' => null,
            'sort_order' => 0,
            'notes' => null,
        ];
    }

    public function inProgress(): static
    {
        return $this->state(fn () => [
            'status' => WorkOrderStatus::InProgress,
            'started_at' => now()->subMinutes(fake()->numberBetween(10, 60)),
        ]);
    }

    public function done(): static
    {
        return $this->state(fn () => [
            'status' => WorkOrderStatus::Done,
            'started_at' => now()->subHours(2),
            'completed_at' => now(),
            'actual_duration' => fake()->numberBetween(30, 180),
        ]);
    }
}
