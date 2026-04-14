<?php

namespace Modules\SFD\AI\Tools;

use Modules\Ai\Neuron\Contracts\ToolMetadataInterface;
use Modules\Ai\Neuron\Traits\HasToolMetadata;
use Modules\SFD\Models\SfdManufacturingOrder;
use Modules\SFD\Services\ManufacturingOrderService;
use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolInterface;
use NeuronAI\Tools\ToolProperty;

class UpdateManufacturingOrderTool extends Tool implements ToolInterface, ToolMetadataInterface
{
    use HasToolMetadata;

    public function __construct()
    {
        parent::__construct(
            name: 'update_manufacturing_order',
            description: <<<'DESC'
Perform an action on a manufacturing order. Available actions:
- "confirm": Moves a Draft order to Confirmed and generates work orders from the BOM operations.
- "complete": Marks a Confirmed or InProgress order as Done, completing all remaining work orders.
- "cancel": Cancels an order (unless already Done), cancelling all non-final work orders.
DESC
        );

        $this->setDisplayName('Update Manufacturing Order')
            ->setDescription('Confirm, complete, or cancel manufacturing orders')
            ->setIcon('pencil-square')
            ->setCategory('Production')
            ->setTags(['sfd', 'manufacturing', 'update'])
            ->setVersion('1.0.0');
    }

    /** @return array<ToolProperty> */
    protected function properties(): array
    {
        return [
            ToolProperty::make(
                name: 'order_id',
                type: PropertyType::INTEGER,
                description: 'ID of the manufacturing order to update',
                required: true
            ),
            ToolProperty::make(
                name: 'action',
                type: PropertyType::STRING,
                description: 'Action to perform: confirm, complete, cancel',
                required: true
            ),
        ];
    }

    /** @return array<string, mixed> */
    public function __invoke(int $order_id, string $action): array
    {
        try {
            $order = SfdManufacturingOrder::find($order_id);
            if (! $order) {
                return ['success' => false, 'error' => "Manufacturing order #{$order_id} not found"];
            }

            $service = app(ManufacturingOrderService::class);

            match ($action) {
                'confirm' => $service->confirm($order),
                'complete' => $service->complete($order),
                'cancel' => $service->cancel($order),
                default => throw new \InvalidArgumentException("Invalid action: {$action}. Use: confirm, complete, cancel"),
            };

            $order->refresh();
            $workOrderCount = $order->workOrders()->count();

            return [
                'success' => true,
                'data' => [
                    'id' => $order->id,
                    'reference' => $order->reference,
                    'status' => $order->status->value,
                    'work_orders_count' => $workOrderCount,
                ],
                'message' => "Manufacturing order {$order->reference} action '{$action}' completed. Status: {$order->status->value}.",
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Error updating manufacturing order: '.$e->getMessage()];
        }
    }
}
