<?php

namespace Modules\SFD\AI\Tools;

use Modules\Ai\Neuron\Contracts\ToolMetadataInterface;
use Modules\Ai\Neuron\Traits\HasToolMetadata;
use Modules\SFD\Enums\ManufacturingOrderPriority;
use Modules\SFD\Enums\ManufacturingOrderStatus;
use Modules\SFD\Models\SfdBillOfMaterial;
use Modules\SFD\Models\SfdManufacturingOrder;
use Modules\SFD\Models\SfdProduct;
use Modules\SFD\Services\ManufacturingOrderService;
use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolInterface;
use NeuronAI\Tools\ToolProperty;

class CreateManufacturingOrderTool extends Tool implements ToolInterface, ToolMetadataInterface
{
    use HasToolMetadata;

    public function __construct()
    {
        parent::__construct(
            name: 'create_manufacturing_order',
            description: 'Create a new manufacturing order for a product. The order is created in Draft status. Use the Update Manufacturing Order tool to confirm it and generate work orders.'
        );

        $this->setDisplayName('Create Manufacturing Order')
            ->setDescription('Create manufacturing orders for products')
            ->setIcon('plus-circle')
            ->setCategory('Production')
            ->setTags(['sfd', 'manufacturing', 'create'])
            ->setVersion('1.0.0');
    }

    /** @return array<ToolProperty> */
    protected function properties(): array
    {
        return [
            ToolProperty::make(
                name: 'product_id',
                type: PropertyType::INTEGER,
                description: 'ID of the product to manufacture',
                required: true
            ),
            ToolProperty::make(
                name: 'bom_id',
                type: PropertyType::INTEGER,
                description: 'ID of the bill of materials to use. Must belong to the selected product.',
                required: true
            ),
            ToolProperty::make(
                name: 'quantity',
                type: PropertyType::NUMBER,
                description: 'Number of units to produce',
                required: true
            ),
            ToolProperty::make(
                name: 'priority',
                type: PropertyType::STRING,
                description: 'Priority: low, normal, high, urgent. Defaults to normal.',
                required: false
            ),
            ToolProperty::make(
                name: 'scheduled_date',
                type: PropertyType::STRING,
                description: 'Planned start date (YYYY-MM-DD)',
                required: false
            ),
            ToolProperty::make(
                name: 'deadline',
                type: PropertyType::STRING,
                description: 'Deadline date (YYYY-MM-DD)',
                required: false
            ),
            ToolProperty::make(
                name: 'notes',
                type: PropertyType::STRING,
                description: 'Additional notes for this order',
                required: false
            ),
        ];
    }

    /** @return array<string, mixed> */
    public function __invoke(
        int $product_id,
        int $bom_id,
        float $quantity,
        ?string $priority = null,
        ?string $scheduled_date = null,
        ?string $deadline = null,
        ?string $notes = null,
    ): array {
        try {
            $product = SfdProduct::find($product_id);
            if (! $product) {
                return ['success' => false, 'error' => "Product #{$product_id} not found"];
            }

            $bom = SfdBillOfMaterial::where('id', $bom_id)
                ->where('product_id', $product_id)
                ->first();
            if (! $bom) {
                return ['success' => false, 'error' => "BOM #{$bom_id} not found or does not belong to product #{$product_id}"];
            }

            $order = SfdManufacturingOrder::create([
                'reference' => ManufacturingOrderService::generateReference(),
                'product_id' => $product_id,
                'bom_id' => $bom_id,
                'quantity' => $quantity,
                'status' => ManufacturingOrderStatus::Draft,
                'priority' => $priority ? ManufacturingOrderPriority::from($priority) : ManufacturingOrderPriority::Normal,
                'scheduled_date' => $scheduled_date,
                'deadline' => $deadline,
                'notes' => $notes,
            ]);

            return [
                'success' => true,
                'data' => [
                    'id' => $order->id,
                    'reference' => $order->reference,
                    'product' => $product->name,
                    'bom' => $bom->name,
                    'quantity' => $order->quantity,
                    'status' => $order->status->value,
                    'priority' => $order->priority->value,
                ],
                'message' => "Manufacturing order {$order->reference} created in Draft status. Use 'update_manufacturing_order' with action 'confirm' to generate work orders.",
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Error creating manufacturing order: '.$e->getMessage()];
        }
    }
}
