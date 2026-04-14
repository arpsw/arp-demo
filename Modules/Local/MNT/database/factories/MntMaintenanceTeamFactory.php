<?php

namespace Modules\MNT\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\MNT\Models\MntMaintenanceTeam;

class MntMaintenanceTeamFactory extends Factory
{
    protected $model = MntMaintenanceTeam::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true).' Team',
            'color' => fake()->optional()->hexColor(),
            'company' => fake()->optional()->company(),
        ];
    }
}
