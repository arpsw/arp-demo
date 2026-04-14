<?php

namespace Modules\MNT\AI\Tools;

use Modules\Ai\Neuron\Contracts\ToolMetadataInterface;
use Modules\Ai\Neuron\Traits\HasToolMetadata;
use Modules\MNT\Models\MntMaintenanceRequest;
use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolInterface;
use NeuronAI\Tools\ToolProperty;

class ReadMaintenanceRequestsTool extends Tool implements ToolInterface, ToolMetadataInterface
{
    use HasToolMetadata;

    public function __construct()
    {
        parent::__construct(
            name: 'read_maintenance_requests',
            description: 'List, search, and filter maintenance requests by type, stage, team, or equipment.'
        );

        $this->setDisplayName('Read Maintenance Requests')
            ->setDescription('Query maintenance requests with filtering options')
            ->setIcon('clipboard-document-list')
            ->setCategory('Maintenance')
            ->setTags(['maintenance', 'requests', 'read'])
            ->setVersion('1.0.0');
    }

    /** @return array<ToolProperty> */
    protected function properties(): array
    {
        return [
            ToolProperty::make(
                name: 'request_id',
                type: PropertyType::INTEGER,
                description: 'Specific request ID to retrieve',
                required: false
            ),
            ToolProperty::make(
                name: 'equipment_id',
                type: PropertyType::INTEGER,
                description: 'Filter by equipment ID',
                required: false
            ),
            ToolProperty::make(
                name: 'stage',
                type: PropertyType::STRING,
                description: 'Filter by stage: new, in_progress, repaired, scrap',
                required: false
            ),
            ToolProperty::make(
                name: 'request_type',
                type: PropertyType::STRING,
                description: 'Filter by type: corrective, preventive',
                required: false
            ),
        ];
    }

    /** @return array<string, mixed> */
    public function __invoke(
        ?int $request_id = null,
        ?int $equipment_id = null,
        ?string $stage = null,
        ?string $request_type = null,
    ): array {
        try {
            if ($request_id) {
                $request = MntMaintenanceRequest::with(['equipment', 'team', 'technician', 'requestedBy'])
                    ->find($request_id);

                if (! $request) {
                    return ['success' => false, 'error' => "Request #{$request_id} not found"];
                }

                return [
                    'success' => true,
                    'data' => [
                        'id' => $request->id,
                        'reference' => $request->reference,
                        'name' => $request->name,
                        'request_type' => $request->request_type->value,
                        'priority' => $request->priority->value,
                        'stage' => $request->stage->value,
                        'equipment' => $request->equipment?->name,
                        'team' => $request->team?->name,
                        'technician' => $request->technician?->name,
                        'requested_by' => $request->requestedBy?->name,
                        'scheduled_date' => $request->scheduled_date?->toDateString(),
                        'close_date' => $request->close_date?->toDateString(),
                        'duration' => $request->duration,
                        'description' => $request->description,
                    ],
                ];
            }

            $builder = MntMaintenanceRequest::with(['equipment', 'team', 'technician'])
                ->when($equipment_id, fn ($q) => $q->where('equipment_id', $equipment_id))
                ->when($stage, fn ($q) => $q->where('stage', $stage))
                ->when($request_type, fn ($q) => $q->where('request_type', $request_type))
                ->orderByDesc('created_at');

            $requests = $builder->limit(20)->get();

            return [
                'success' => true,
                'data' => $requests->map(fn ($r) => [
                    'id' => $r->id,
                    'reference' => $r->reference,
                    'name' => $r->name,
                    'request_type' => $r->request_type->value,
                    'priority' => $r->priority->value,
                    'stage' => $r->stage->value,
                    'equipment' => $r->equipment?->name,
                    'scheduled_date' => $r->scheduled_date?->toDateString(),
                ])->toArray(),
                'count' => $requests->count(),
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Error reading requests: '.$e->getMessage()];
        }
    }
}
