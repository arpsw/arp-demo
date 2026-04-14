<?php

namespace Modules\MNT\AI\Tools;

use Modules\Ai\Neuron\Contracts\ToolMetadataInterface;
use Modules\Ai\Neuron\Traits\HasToolMetadata;
use Modules\MNT\Models\MntMaintenanceRequest;
use Modules\MNT\Services\MaintenanceRequestService;
use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolInterface;
use NeuronAI\Tools\ToolProperty;

class UpdateMaintenanceRequestTool extends Tool implements ToolInterface, ToolMetadataInterface
{
    use HasToolMetadata;

    public function __construct()
    {
        parent::__construct(
            name: 'update_maintenance_request',
            description: 'Update a maintenance request stage, assign technician, or add notes.'
        );

        $this->setDisplayName('Update Maintenance Request')
            ->setDescription('Update maintenance request stage, technician, or notes')
            ->setIcon('pencil-square')
            ->setCategory('Maintenance')
            ->setTags(['maintenance', 'request', 'update'])
            ->setVersion('1.0.0');
    }

    /** @return array<ToolProperty> */
    protected function properties(): array
    {
        return [
            ToolProperty::make(
                name: 'request_id',
                type: PropertyType::INTEGER,
                description: 'The maintenance request ID to update',
                required: true
            ),
            ToolProperty::make(
                name: 'action',
                type: PropertyType::STRING,
                description: 'Action to perform: start, complete, scrap, or update',
                required: true
            ),
            ToolProperty::make(
                name: 'technician_id',
                type: PropertyType::INTEGER,
                description: 'Assign a technician (user ID)',
                required: false
            ),
            ToolProperty::make(
                name: 'notes',
                type: PropertyType::STRING,
                description: 'Add notes to the request',
                required: false
            ),
        ];
    }

    /** @return array<string, mixed> */
    public function __invoke(
        int $request_id,
        string $action,
        ?int $technician_id = null,
        ?string $notes = null,
    ): array {
        try {
            $request = MntMaintenanceRequest::find($request_id);
            if (! $request) {
                return ['success' => false, 'error' => "Request #{$request_id} not found"];
            }

            $service = app(MaintenanceRequestService::class);

            match ($action) {
                'start' => $service->start($request),
                'complete' => $service->complete($request),
                'scrap' => $service->scrap($request),
                'update' => null,
                default => throw new \InvalidArgumentException("Unknown action: {$action}"),
            };

            $updates = [];
            if ($technician_id) {
                $updates['technician_id'] = $technician_id;
            }
            if ($notes) {
                $updates['notes'] = $request->notes
                    ? $request->notes."\n".$notes
                    : $notes;
            }
            if ($updates) {
                $request->update($updates);
            }

            $request->refresh();

            return [
                'success' => true,
                'data' => [
                    'id' => $request->id,
                    'reference' => $request->reference,
                    'stage' => $request->stage->value,
                    'technician_id' => $request->technician_id,
                    'notes' => $request->notes,
                ],
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Error updating request: '.$e->getMessage()];
        }
    }
}
