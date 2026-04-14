<?php

namespace Modules\SFD\AI\Tools;

use Modules\Ai\Neuron\Contracts\ToolMetadataInterface;
use Modules\Ai\Neuron\Traits\HasToolMetadata;
use Modules\SFD\Models\SfdWorkCenter;
use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolInterface;
use NeuronAI\Tools\ToolProperty;

class ReadWorkCentersTool extends Tool implements ToolInterface, ToolMetadataInterface
{
    use HasToolMetadata;

    public function __construct()
    {
        parent::__construct(
            name: 'read_work_centers',
            description: 'List work centers with their capacity, cost, and equipment. Use this to understand the production layout.'
        );

        $this->setDisplayName('Read Work Centers')
            ->setDescription('Query work centers and their equipment')
            ->setIcon('building-office')
            ->setCategory('Production')
            ->setTags(['sfd', 'work-centers', 'read'])
            ->setVersion('1.0.0');
    }

    /** @return array<ToolProperty> */
    protected function properties(): array
    {
        return [
            ToolProperty::make(
                name: 'work_center_id',
                type: PropertyType::INTEGER,
                description: 'Specific work center ID to retrieve (includes equipment list)',
                required: false
            ),
        ];
    }

    /** @return array<string, mixed> */
    public function __invoke(?int $work_center_id = null): array
    {
        try {
            if ($work_center_id) {
                $wc = SfdWorkCenter::with(['equipment.category'])->find($work_center_id);

                if (! $wc) {
                    return ['success' => false, 'error' => "Work center #{$work_center_id} not found"];
                }

                return [
                    'success' => true,
                    'data' => [
                        'id' => $wc->id,
                        'name' => $wc->name,
                        'code' => $wc->code,
                        'capacity' => $wc->capacity,
                        'cost_per_hour' => $wc->cost_per_hour,
                        'is_active' => $wc->is_active,
                        'equipment' => $wc->equipment->map(fn ($eq) => [
                            'id' => $eq->id,
                            'name' => $eq->name,
                            'serial_number' => $eq->serial_number,
                            'status' => $eq->status?->value,
                            'category' => $eq->category?->name,
                        ])->toArray(),
                    ],
                ];
            }

            $workCenters = SfdWorkCenter::orderBy('sort_order')->get();

            return [
                'success' => true,
                'data' => $workCenters->map(fn ($wc) => [
                    'id' => $wc->id,
                    'name' => $wc->name,
                    'code' => $wc->code,
                    'capacity' => $wc->capacity,
                    'cost_per_hour' => $wc->cost_per_hour,
                    'is_active' => $wc->is_active,
                ])->toArray(),
                'count' => $workCenters->count(),
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Error reading work centers: '.$e->getMessage()];
        }
    }
}
