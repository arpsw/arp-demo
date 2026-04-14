<?php

namespace Modules\MNT\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\MNT\Enums\MaintenancePriority;
use Modules\MNT\Enums\MaintenanceRequestType;
use Modules\MNT\Enums\MaintenanceStage;
use Modules\MNT\Models\MntEquipment;
use Modules\MNT\Models\MntMaintenanceRequest;

class MntMaintenanceRequestFactory extends Factory
{
    protected $model = MntMaintenanceRequest::class;

    public function definition(): array
    {
        static $counter = 0;
        $counter++;

        return [
            'reference' => sprintf('MR-%04d', $counter),
            'name' => fake()->sentence(4),
            'equipment_id' => MntEquipment::factory(),
            'request_type' => MaintenanceRequestType::Corrective,
            'priority' => MaintenancePriority::Normal,
            'stage' => MaintenanceStage::New,
            'scheduled_date' => fake()->optional()->dateTimeBetween('now', '+30 days'),
            'description' => fake()->optional()->paragraph(),
        ];
    }

    public function preventive(): static
    {
        return $this->state(fn () => [
            'request_type' => MaintenanceRequestType::Preventive,
        ]);
    }

    public function corrective(): static
    {
        return $this->state(fn () => [
            'request_type' => MaintenanceRequestType::Corrective,
        ]);
    }
}
