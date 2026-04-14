<?php

namespace Modules\MNT\AI\Tools;

use Modules\Ai\Neuron\Contracts\ToolMetadataInterface;
use Modules\Ai\Neuron\Traits\HasToolMetadata;
use Modules\MNT\Models\MntEquipment;
use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolInterface;
use NeuronAI\Tools\ToolProperty;

class ReadEquipmentTool extends Tool implements ToolInterface, ToolMetadataInterface
{
    use HasToolMetadata;

    public function __construct()
    {
        parent::__construct(
            name: 'read_equipment',
            description: 'List, search, or get equipment with status, MTBF, category, and work center info.'
        );

        $this->setDisplayName('Read Equipment')
            ->setDescription('Query equipment data including status, statistics, and linked work centers')
            ->setIcon('wrench-screwdriver')
            ->setCategory('Maintenance')
            ->setTags(['equipment', 'maintenance', 'read'])
            ->setVersion('1.0.0');
    }

    /** @return array<ToolProperty> */
    protected function properties(): array
    {
        return [
            ToolProperty::make(
                name: 'equipment_id',
                type: PropertyType::INTEGER,
                description: 'Specific equipment ID to retrieve',
                required: false
            ),
            ToolProperty::make(
                name: 'query',
                type: PropertyType::STRING,
                description: 'Search query to find equipment by name, serial number, or manufacturer',
                required: false
            ),
            ToolProperty::make(
                name: 'status',
                type: PropertyType::STRING,
                description: 'Filter by status: operational, maintenance, out_of_service, retired',
                required: false
            ),
        ];
    }

    /** @return array<string, mixed> */
    public function __invoke(
        ?int $equipment_id = null,
        ?string $query = null,
        ?string $status = null,
    ): array {
        try {
            if ($equipment_id) {
                $equipment = MntEquipment::with(['category', 'workCenter', 'technician'])->find($equipment_id);

                if (! $equipment) {
                    return ['success' => false, 'error' => "Equipment #{$equipment_id} not found"];
                }

                return [
                    'success' => true,
                    'data' => [
                        'id' => $equipment->id,
                        'name' => $equipment->name,
                        'serial_number' => $equipment->serial_number,
                        'status' => $equipment->status->value,
                        'category' => $equipment->category?->name,
                        'work_center' => $equipment->workCenter?->name,
                        'technician' => $equipment->technician?->name,
                        'manufacturer' => $equipment->manufacturer,
                        'model' => $equipment->model,
                        'location' => $equipment->location,
                        'mtbf' => $equipment->mtbf,
                        'mttr' => $equipment->mttr,
                        'next_preventive_date' => $equipment->next_preventive_date?->toDateString(),
                    ],
                ];
            }

            $builder = MntEquipment::with(['category', 'workCenter'])
                ->when($query, fn ($q) => $q->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('serial_number', 'like', "%{$query}%")
                        ->orWhere('manufacturer', 'like', "%{$query}%");
                }))
                ->when($status, fn ($q) => $q->where('status', $status));

            $equipment = $builder->limit(20)->get();

            return [
                'success' => true,
                'data' => $equipment->map(fn ($e) => [
                    'id' => $e->id,
                    'name' => $e->name,
                    'serial_number' => $e->serial_number,
                    'status' => $e->status->value,
                    'category' => $e->category?->name,
                    'work_center' => $e->workCenter?->name,
                ])->toArray(),
                'count' => $equipment->count(),
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Error reading equipment: '.$e->getMessage()];
        }
    }
}
