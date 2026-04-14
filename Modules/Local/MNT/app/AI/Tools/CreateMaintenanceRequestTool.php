<?php

namespace Modules\MNT\AI\Tools;

use Modules\Ai\Neuron\Contracts\ToolMetadataInterface;
use Modules\Ai\Neuron\Traits\HasToolMetadata;
use Modules\MNT\Enums\MaintenancePriority;
use Modules\MNT\Enums\MaintenanceRequestType;
use Modules\MNT\Enums\MaintenanceStage;
use Modules\MNT\Models\MntEquipment;
use Modules\MNT\Models\MntMaintenanceRequest;
use Modules\MNT\Services\MaintenanceRequestService;
use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolInterface;
use NeuronAI\Tools\ToolProperty;

class CreateMaintenanceRequestTool extends Tool implements ToolInterface, ToolMetadataInterface
{
    use HasToolMetadata;

    public function __construct()
    {
        parent::__construct(
            name: 'create_maintenance_request',
            description: 'Create a new corrective or preventive maintenance request for equipment.'
        );

        $this->setDisplayName('Create Maintenance Request')
            ->setDescription('Create maintenance requests for equipment')
            ->setIcon('plus-circle')
            ->setCategory('Maintenance')
            ->setTags(['maintenance', 'request', 'create'])
            ->setVersion('1.0.0');
    }

    /** @return array<ToolProperty> */
    protected function properties(): array
    {
        return [
            ToolProperty::make(
                name: 'name',
                type: PropertyType::STRING,
                description: 'Subject/description of the maintenance request',
                required: true
            ),
            ToolProperty::make(
                name: 'equipment_id',
                type: PropertyType::INTEGER,
                description: 'Equipment ID for the request',
                required: true
            ),
            ToolProperty::make(
                name: 'request_type',
                type: PropertyType::STRING,
                description: 'Type: corrective or preventive',
                required: true
            ),
            ToolProperty::make(
                name: 'priority',
                type: PropertyType::STRING,
                description: 'Priority: low, normal, high, urgent',
                required: false
            ),
            ToolProperty::make(
                name: 'description',
                type: PropertyType::STRING,
                description: 'Detailed description of the issue',
                required: false
            ),
        ];
    }

    /** @return array<string, mixed> */
    public function __invoke(
        string $name,
        int $equipment_id,
        string $request_type,
        ?string $priority = null,
        ?string $description = null,
    ): array {
        try {
            $equipment = MntEquipment::find($equipment_id);
            if (! $equipment) {
                return ['success' => false, 'error' => "Equipment #{$equipment_id} not found"];
            }

            $request = MntMaintenanceRequest::create([
                'reference' => MaintenanceRequestService::generateReference(),
                'name' => $name,
                'equipment_id' => $equipment_id,
                'category_id' => $equipment->category_id,
                'request_type' => MaintenanceRequestType::from($request_type),
                'priority' => $priority ? MaintenancePriority::from($priority) : MaintenancePriority::Normal,
                'stage' => MaintenanceStage::New,
                'description' => $description,
                'requested_by' => auth()->id(),
            ]);

            return [
                'success' => true,
                'data' => [
                    'id' => $request->id,
                    'reference' => $request->reference,
                    'name' => $request->name,
                    'equipment' => $equipment->name,
                    'request_type' => $request->request_type->value,
                    'priority' => $request->priority->value,
                    'stage' => $request->stage->value,
                ],
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Error creating request: '.$e->getMessage()];
        }
    }
}
