<?php

namespace Modules\SFD\AI\Tools;

use Modules\Ai\Neuron\Contracts\ToolMetadataInterface;
use Modules\Ai\Neuron\Traits\HasToolMetadata;
use Modules\SFD\Models\SfdManufacturingOrder;
use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolInterface;
use NeuronAI\Tools\ToolProperty;

class ReadManufacturingOrdersTool extends Tool implements ToolInterface, ToolMetadataInterface
{
    use HasToolMetadata;

    public function __construct()
    {
        parent::__construct(
            name: 'read_manufacturing_orders',
            description: 'List, search, and filter manufacturing orders by status, product, priority, or date range.'
        );

        $this->setDisplayName('Read Manufacturing Orders')
            ->setDescription('Query manufacturing orders with filtering options')
            ->setIcon('clipboard-document-check')
            ->setCategory('Production')
            ->setTags(['sfd', 'manufacturing', 'orders', 'read'])
            ->setVersion('1.0.0');
    }

    /** @return array<ToolProperty> */
    protected function properties(): array
    {
        return [
            ToolProperty::make(
                name: 'order_id',
                type: PropertyType::INTEGER,
                description: 'Specific manufacturing order ID to retrieve (returns full detail with work orders)',
                required: false
            ),
            ToolProperty::make(
                name: 'status',
                type: PropertyType::STRING,
                description: 'Filter by status: draft, confirmed, in_progress, done, cancelled',
                required: false
            ),
            ToolProperty::make(
                name: 'priority',
                type: PropertyType::STRING,
                description: 'Filter by priority: low, normal, high, urgent',
                required: false
            ),
            ToolProperty::make(
                name: 'product_id',
                type: PropertyType::INTEGER,
                description: 'Filter by product ID',
                required: false
            ),
        ];
    }

    /** @return array<string, mixed> */
    public function __invoke(
        ?int $order_id = null,
        ?string $status = null,
        ?string $priority = null,
        ?int $product_id = null,
    ): array {
        try {
            if ($order_id) {
                $order = SfdManufacturingOrder::with(['product', 'billOfMaterial', 'workOrders.workCenter', 'workOrders.assignedUser'])
                    ->find($order_id);

                if (! $order) {
                    return ['success' => false, 'error' => "Manufacturing order #{$order_id} not found"];
                }

                return [
                    'success' => true,
                    'data' => [
                        'id' => $order->id,
                        'reference' => $order->reference,
                        'product' => $order->product?->name,
                        'product_id' => $order->product_id,
                        'bom' => $order->billOfMaterial?->name,
                        'quantity' => $order->quantity,
                        'status' => $order->status->value,
                        'priority' => $order->priority->value,
                        'scheduled_date' => $order->scheduled_date?->toDateString(),
                        'deadline' => $order->deadline?->toDateString(),
                        'completed_at' => $order->completed_at?->toDateTimeString(),
                        'notes' => $order->notes,
                        'work_orders' => $order->workOrders->map(fn ($wo) => [
                            'id' => $wo->id,
                            'name' => $wo->name,
                            'status' => $wo->status->value,
                            'work_center' => $wo->workCenter?->name,
                            'assigned_to' => $wo->assignedUser?->name,
                            'expected_duration' => $wo->expected_duration,
                            'actual_duration' => $wo->actual_duration,
                            'started_at' => $wo->started_at?->toDateTimeString(),
                            'completed_at' => $wo->completed_at?->toDateTimeString(),
                            'notes' => $wo->notes,
                            'sort_order' => $wo->sort_order,
                        ])->toArray(),
                    ],
                ];
            }

            $builder = SfdManufacturingOrder::with(['product'])
                ->when($status, fn ($q) => $q->where('status', $status))
                ->when($priority, fn ($q) => $q->where('priority', $priority))
                ->when($product_id, fn ($q) => $q->where('product_id', $product_id))
                ->orderByDesc('created_at');

            $orders = $builder->limit(20)->get();

            return [
                'success' => true,
                'data' => $orders->map(fn ($o) => [
                    'id' => $o->id,
                    'reference' => $o->reference,
                    'product' => $o->product?->name,
                    'quantity' => $o->quantity,
                    'status' => $o->status->value,
                    'priority' => $o->priority->value,
                    'scheduled_date' => $o->scheduled_date?->toDateString(),
                    'deadline' => $o->deadline?->toDateString(),
                ])->toArray(),
                'count' => $orders->count(),
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Error reading manufacturing orders: '.$e->getMessage()];
        }
    }
}
