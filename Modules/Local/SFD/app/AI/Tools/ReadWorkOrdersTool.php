<?php

namespace Modules\SFD\AI\Tools;

use Modules\Ai\Neuron\Contracts\ToolMetadataInterface;
use Modules\Ai\Neuron\Traits\HasToolMetadata;
use Modules\SFD\Models\SfdWorkOrder;
use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolInterface;
use NeuronAI\Tools\ToolProperty;

class ReadWorkOrdersTool extends Tool implements ToolInterface, ToolMetadataInterface
{
    use HasToolMetadata;

    public function __construct()
    {
        parent::__construct(
            name: 'read_work_orders',
            description: 'List, search, and filter work orders by status, work center, manufacturing order, or assigned operator.'
        );

        $this->setDisplayName('Read Work Orders')
            ->setDescription('Query work orders with filtering options')
            ->setIcon('wrench-screwdriver')
            ->setCategory('Production')
            ->setTags(['sfd', 'work-orders', 'read'])
            ->setVersion('1.0.0');
    }

    /** @return array<ToolProperty> */
    protected function properties(): array
    {
        return [
            ToolProperty::make(
                name: 'work_order_id',
                type: PropertyType::INTEGER,
                description: 'Specific work order ID to retrieve (returns full detail with time logs and quality checks)',
                required: false
            ),
            ToolProperty::make(
                name: 'manufacturing_order_id',
                type: PropertyType::INTEGER,
                description: 'Filter by manufacturing order ID',
                required: false
            ),
            ToolProperty::make(
                name: 'status',
                type: PropertyType::STRING,
                description: 'Filter by status: pending, ready, in_progress, paused, done, cancelled',
                required: false
            ),
            ToolProperty::make(
                name: 'work_center_id',
                type: PropertyType::INTEGER,
                description: 'Filter by work center ID',
                required: false
            ),
        ];
    }

    /** @return array<string, mixed> */
    public function __invoke(
        ?int $work_order_id = null,
        ?int $manufacturing_order_id = null,
        ?string $status = null,
        ?int $work_center_id = null,
    ): array {
        try {
            if ($work_order_id) {
                $wo = SfdWorkOrder::with([
                    'manufacturingOrder',
                    'workCenter',
                    'assignedUser',
                    'timeLogs',
                    'qualityChecks',
                ])->find($work_order_id);

                if (! $wo) {
                    return ['success' => false, 'error' => "Work order #{$work_order_id} not found"];
                }

                return [
                    'success' => true,
                    'data' => [
                        'id' => $wo->id,
                        'name' => $wo->name,
                        'manufacturing_order' => $wo->manufacturingOrder?->reference,
                        'manufacturing_order_id' => $wo->manufacturing_order_id,
                        'work_center' => $wo->workCenter?->name,
                        'work_center_id' => $wo->work_center_id,
                        'status' => $wo->status->value,
                        'assigned_to' => $wo->assignedUser?->name,
                        'expected_duration' => $wo->expected_duration,
                        'actual_duration' => $wo->actual_duration,
                        'started_at' => $wo->started_at?->toDateTimeString(),
                        'completed_at' => $wo->completed_at?->toDateTimeString(),
                        'notes' => $wo->notes,
                        'sort_order' => $wo->sort_order,
                        'time_logs' => $wo->timeLogs->map(fn ($tl) => [
                            'id' => $tl->id,
                            'user_id' => $tl->user_id,
                            'started_at' => $tl->started_at?->toDateTimeString(),
                            'ended_at' => $tl->ended_at?->toDateTimeString(),
                            'duration_minutes' => $tl->duration_minutes,
                        ])->toArray(),
                        'quality_checks' => $wo->qualityChecks->map(fn ($qc) => [
                            'id' => $qc->id,
                            'name' => $qc->name,
                            'type' => $qc->type->value,
                            'result' => $qc->result?->value,
                            'measured_value' => $qc->measured_value,
                        ])->toArray(),
                    ],
                ];
            }

            $builder = SfdWorkOrder::with(['manufacturingOrder', 'workCenter', 'assignedUser'])
                ->when($manufacturing_order_id, fn ($q) => $q->where('manufacturing_order_id', $manufacturing_order_id))
                ->when($status, fn ($q) => $q->where('status', $status))
                ->when($work_center_id, fn ($q) => $q->where('work_center_id', $work_center_id))
                ->orderBy('sort_order');

            $workOrders = $builder->limit(30)->get();

            return [
                'success' => true,
                'data' => $workOrders->map(fn ($wo) => [
                    'id' => $wo->id,
                    'name' => $wo->name,
                    'manufacturing_order' => $wo->manufacturingOrder?->reference,
                    'work_center' => $wo->workCenter?->name,
                    'status' => $wo->status->value,
                    'assigned_to' => $wo->assignedUser?->name,
                    'expected_duration' => $wo->expected_duration,
                    'actual_duration' => $wo->actual_duration,
                    'notes' => $wo->notes,
                ])->toArray(),
                'count' => $workOrders->count(),
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Error reading work orders: '.$e->getMessage()];
        }
    }
}
