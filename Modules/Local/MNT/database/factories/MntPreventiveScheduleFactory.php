<?php

namespace Modules\MNT\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\MNT\Enums\MaintenancePriority;
use Modules\MNT\Models\MntEquipment;
use Modules\MNT\Models\MntPreventiveSchedule;

class MntPreventiveScheduleFactory extends Factory
{
    protected $model = MntPreventiveSchedule::class;

    public function definition(): array
    {
        return [
            'equipment_id' => MntEquipment::factory(),
            'name' => fake()->sentence(3),
            'frequency_days' => fake()->randomElement([7, 14, 30, 60, 90]),
            'priority' => MaintenancePriority::Normal,
            'description' => fake()->optional()->paragraph(),
            'is_active' => true,
            'next_date' => fake()->dateTimeBetween('now', '+30 days'),
        ];
    }
}
