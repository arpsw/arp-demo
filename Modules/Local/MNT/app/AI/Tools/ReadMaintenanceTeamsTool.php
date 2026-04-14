<?php

namespace Modules\MNT\AI\Tools;

use Modules\Ai\Neuron\Contracts\ToolMetadataInterface;
use Modules\Ai\Neuron\Traits\HasToolMetadata;
use Modules\MNT\Models\MntMaintenanceTeam;
use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolInterface;
use NeuronAI\Tools\ToolProperty;

class ReadMaintenanceTeamsTool extends Tool implements ToolInterface, ToolMetadataInterface
{
    use HasToolMetadata;

    public function __construct()
    {
        parent::__construct(
            name: 'read_maintenance_teams',
            description: 'List maintenance teams with their members and contact details (phone numbers). Use this to find the right team and person to contact for a specific type of maintenance issue.'
        );

        $this->setDisplayName('Read Maintenance Teams')
            ->setDescription('List maintenance teams with members and phone numbers')
            ->setIcon('user-group')
            ->setCategory('Maintenance')
            ->setTags(['maintenance', 'teams', 'contacts', 'phone'])
            ->setVersion('1.0.0');
    }

    /** @return array<ToolProperty> */
    protected function properties(): array
    {
        return [
            ToolProperty::make(
                name: 'team_name',
                type: PropertyType::STRING,
                description: 'Optional: filter by team name (partial match)',
                required: false
            ),
        ];
    }

    /** @return array<string, mixed> */
    public function __invoke(?string $team_name = null): array
    {
        try {
            $query = MntMaintenanceTeam::with('members');

            if ($team_name) {
                $query->where('name', 'like', "%{$team_name}%");
            }

            $teams = $query->get();

            return [
                'success' => true,
                'data' => $teams->map(fn (MntMaintenanceTeam $team) => [
                    'id' => $team->id,
                    'name' => $team->name,
                    'company' => $team->company,
                    'members' => $team->members->map(fn ($member) => [
                        'id' => $member->id,
                        'first_name' => $member->first_name,
                        'last_name' => $member->last_name,
                        'full_name' => $member->full_name,
                        'phone' => $member->phone,
                        'role' => $member->role->value,
                    ])->toArray(),
                ])->toArray(),
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Error reading teams: '.$e->getMessage()];
        }
    }
}
