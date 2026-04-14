<?php

namespace Modules\SFD\AI\Tools;

use Modules\Ai\Neuron\Contracts\ToolMetadataInterface;
use Modules\Ai\Neuron\Traits\HasToolMetadata;
use Modules\SFD\Models\SfdWorkOrder;
use Modules\SFD\Services\WorkOrderService;
use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolInterface;
use NeuronAI\Tools\ToolProperty;

class UpdateWorkOrderTool extends Tool implements ToolInterface, ToolMetadataInterface
{
    use HasToolMetadata;

    public function __construct()
    {
        parent::__construct(
            name: 'update_work_order',
            description: <<<'DESC'
Perform an action on a work order. Available actions:
- "start": Start a Pending or Ready work order. Creates a time log entry and transitions the parent manufacturing order to InProgress.
- "complete": Complete an InProgress work order. Closes the active time log and calculates total duration.
- "pause": Pause an InProgress work order (moves to Ready, can be resumed with "start").
- "malfunction": Report a malfunction on an InProgress work order. Pauses it and records the problem description. This triggers the maintenance automation.
DESC
        );

        $this->setDisplayName('Update Work Order')
            ->setDescription('Start, complete, pause, or report malfunction on work orders')
            ->setIcon('wrench')
            ->setCategory('Production')
            ->setTags(['sfd', 'work-orders', 'update'])
            ->setVersion('1.0.0');
    }

    /** @return array<ToolProperty> */
    protected function properties(): array
    {
        return [
            ToolProperty::make(
                name: 'work_order_id',
                type: PropertyType::INTEGER,
                description: 'ID of the work order to update',
                required: true
            ),
            ToolProperty::make(
                name: 'action',
                type: PropertyType::STRING,
                description: 'Action to perform: start, complete, pause, malfunction',
                required: true
            ),
            ToolProperty::make(
                name: 'description',
                type: PropertyType::STRING,
                description: 'Required for "malfunction" action: description of the problem (e.g. "Sparks from welding station, unusual motor noise")',
                required: false
            ),
        ];
    }

    /** @return array<string, mixed> */
    public function __invoke(int $work_order_id, string $action, ?string $description = null): array
    {
        try {
            $wo = SfdWorkOrder::find($work_order_id);
            if (! $wo) {
                return ['success' => false, 'error' => "Work order #{$work_order_id} not found"];
            }

            $service = app(WorkOrderService::class);

            match ($action) {
                'start' => $service->start($wo),
                'complete' => $service->complete($wo),
                'pause' => $service->pause($wo),
                'malfunction' => $description
                    ? $service->malfunction($wo, $description)
                    : throw new \InvalidArgumentException('Description is required for malfunction action'),
                default => throw new \InvalidArgumentException("Invalid action: {$action}. Use: start, complete, pause, malfunction"),
            };

            $wo->refresh();

            return [
                'success' => true,
                'data' => [
                    'id' => $wo->id,
                    'name' => $wo->name,
                    'status' => $wo->status->value,
                    'started_at' => $wo->started_at?->toDateTimeString(),
                    'completed_at' => $wo->completed_at?->toDateTimeString(),
                    'actual_duration' => $wo->actual_duration,
                    'notes' => $wo->notes,
                ],
                'message' => "Work order #{$wo->id} ({$wo->name}) action '{$action}' completed. Status: {$wo->status->value}.",
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Error updating work order: '.$e->getMessage()];
        }
    }
}
