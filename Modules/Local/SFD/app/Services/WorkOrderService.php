<?php

namespace Modules\SFD\Services;

use Modules\SFD\Enums\ManufacturingOrderStatus;
use Modules\SFD\Enums\WorkOrderStatus;
use Modules\SFD\Models\SfdWorkOrder;

class WorkOrderService
{
    public function start(SfdWorkOrder $workOrder, ?int $userId = null): void
    {
        if (! in_array($workOrder->status, [WorkOrderStatus::Pending, WorkOrderStatus::Ready])) {
            return;
        }

        $workOrder->update([
            'status' => WorkOrderStatus::InProgress,
            'started_at' => now(),
            'assigned_to' => $userId ?? auth()->id(),
        ]);

        $workOrder->timeLogs()->create([
            'user_id' => $userId ?? auth()->id(),
            'started_at' => now(),
        ]);

        $mo = $workOrder->manufacturingOrder;
        if ($mo->status === ManufacturingOrderStatus::Confirmed) {
            $mo->update(['status' => ManufacturingOrderStatus::InProgress]);
        }
    }

    public function complete(SfdWorkOrder $workOrder): void
    {
        if ($workOrder->status !== WorkOrderStatus::InProgress) {
            return;
        }

        $activeLog = $workOrder->timeLogs()->whereNull('ended_at')->latest()->first();
        if ($activeLog) {
            $duration = $activeLog->started_at->diffInMinutes(now());
            $activeLog->update([
                'ended_at' => now(),
                'duration_minutes' => $duration,
            ]);
        }

        $totalDuration = $workOrder->timeLogs()->sum('duration_minutes');

        $workOrder->update([
            'status' => WorkOrderStatus::Done,
            'completed_at' => now(),
            'actual_duration' => $totalDuration,
        ]);
    }

    public function pause(SfdWorkOrder $workOrder): void
    {
        if ($workOrder->status !== WorkOrderStatus::InProgress) {
            return;
        }

        $this->stopTimeTracking($workOrder);

        $workOrder->update(['status' => WorkOrderStatus::Ready]);
    }

    public function malfunction(SfdWorkOrder $workOrder, string $description): void
    {
        if ($workOrder->status !== WorkOrderStatus::InProgress) {
            return;
        }

        $this->stopTimeTracking($workOrder);

        $workOrder->update([
            'status' => WorkOrderStatus::Paused,
            'notes' => $description,
        ]);
    }

    protected function stopTimeTracking(SfdWorkOrder $workOrder): void
    {
        $activeLog = $workOrder->timeLogs()->whereNull('ended_at')->latest()->first();
        if ($activeLog) {
            $duration = $activeLog->started_at->diffInMinutes(now());
            $activeLog->update([
                'ended_at' => now(),
                'duration_minutes' => $duration,
            ]);
        }
    }
}
