<?php

namespace Modules\MNT\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\MNT\Enums\TeamMemberRole;
use Modules\MNT\Models\MntMaintenanceTeam;
use Modules\MNT\Models\MntMaintenanceTeamMember;

/**
 * @extends Factory<MntMaintenanceTeamMember>
 */
class MntMaintenanceTeamMemberFactory extends Factory
{
    protected $model = MntMaintenanceTeamMember::class;

    public function definition(): array
    {
        return [
            'team_id' => MntMaintenanceTeam::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone' => fake()->e164PhoneNumber(),
            'role' => TeamMemberRole::Member,
        ];
    }

    public function leader(): static
    {
        return $this->state(fn () => [
            'role' => TeamMemberRole::Leader,
        ]);
    }
}
