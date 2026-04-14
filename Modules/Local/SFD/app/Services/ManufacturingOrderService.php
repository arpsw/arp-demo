<?php

namespace Modules\SFD\Services;

use Modules\SFD\Enums\ManufacturingOrderStatus;
use Modules\SFD\Enums\WorkOrderStatus;
use Modules\SFD\Models\SfdManufacturingOrder;

class ManufacturingOrderService
{
    public function confirm(SfdManufacturingOrder $order): void
    {
        if ($order->status !== ManufacturingOrderStatus::Draft) {
            return;
        }

        $operations = $order->billOfMaterial->operations()->orderBy('sort_order')->get();

        foreach ($operations as $operation) {
            $order->workOrders()->create([
                'operation_id' => $operation->id,
                'work_center_id' => $operation->work_center_id,
                'name' => $operation->name,
                'status' => WorkOrderStatus::Pending,
                'expected_duration' => $operation->duration_minutes,
                'sort_order' => $operation->sort_order,
            ]);
        }

        $order->update(['status' => ManufacturingOrderStatus::Confirmed]);
    }

    public function complete(SfdManufacturingOrder $order): void
    {
        if (! in_array($order->status, [ManufacturingOrderStatus::Confirmed, ManufacturingOrderStatus::InProgress])) {
            return;
        }

        $order->workOrders()
            ->whereNotIn('status', [WorkOrderStatus::Done->value, WorkOrderStatus::Cancelled->value])
            ->update(['status' => WorkOrderStatus::Done, 'completed_at' => now()]);

        $order->update([
            'status' => ManufacturingOrderStatus::Done,
            'completed_at' => now(),
        ]);
    }

    public function cancel(SfdManufacturingOrder $order): void
    {
        if ($order->status === ManufacturingOrderStatus::Done) {
            return;
        }

        $order->workOrders()
            ->whereNotIn('status', [WorkOrderStatus::Done->value, WorkOrderStatus::Cancelled->value])
            ->update(['status' => WorkOrderStatus::Cancelled]);

        $order->update(['status' => ManufacturingOrderStatus::Cancelled]);
    }

    public static function generateReference(): string
    {
        $last = SfdManufacturingOrder::query()
            ->orderByDesc('id')
            ->value('reference');

        if ($last && preg_match('/MO-(\d+)/', $last, $matches)) {
            $next = (int) $matches[1] + 1;
        } else {
            $next = 1;
        }

        return 'MO-'.str_pad($next, 4, '0', STR_PAD_LEFT);
    }
}
