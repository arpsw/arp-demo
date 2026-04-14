<?php

namespace Modules\SFD\Filament\Widgets;

use Filament\Widgets\Widget;
use Modules\SFD\Enums\ManufacturingOrderPriority;
use Modules\SFD\Enums\ManufacturingOrderStatus;
use Modules\SFD\Enums\WorkOrderStatus;
use Modules\SFD\Models\SfdManufacturingOrder;
use Modules\SFD\Models\SfdWorkCenter;
use Modules\SFD\Models\SfdWorkOrder;

class ProductionStatusWidget extends Widget
{
    protected string $view = 'sfd::filament.widgets.production-status';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = -1;

    public function getActiveOrders(): array
    {
        return SfdManufacturingOrder::query()
            ->whereIn('status', [
                ManufacturingOrderStatus::Confirmed,
                ManufacturingOrderStatus::InProgress,
            ])
            ->with(['product', 'workOrders'])
            ->orderByRaw('FIELD(priority, ?, ?, ?, ?)', [
                ManufacturingOrderPriority::Urgent->value,
                ManufacturingOrderPriority::High->value,
                ManufacturingOrderPriority::Normal->value,
                ManufacturingOrderPriority::Low->value,
            ])
            ->get()
            ->map(function (SfdManufacturingOrder $mo) {
                $totalWo = $mo->workOrders->count();
                $doneWo = $mo->workOrders->where('status', WorkOrderStatus::Done)->count();
                $inProgressWo = $mo->workOrders->where('status', WorkOrderStatus::InProgress)->count();
                $progress = $totalWo > 0 ? round(($doneWo / $totalWo) * 100) : 0;

                return [
                    'reference' => $mo->reference,
                    'product' => $mo->product->name,
                    'quantity' => (int) $mo->quantity,
                    'status' => $mo->status,
                    'priority' => $mo->priority,
                    'deadline' => $mo->deadline?->format('M j'),
                    'deadline_urgent' => $mo->deadline?->isPast() || $mo->deadline?->isToday(),
                    'progress' => $progress,
                    'done_wo' => $doneWo,
                    'in_progress_wo' => $inProgressWo,
                    'total_wo' => $totalWo,
                ];
            })
            ->toArray();
    }

    public function getWorkCenterLoad(): array
    {
        $workCenters = SfdWorkCenter::query()
            ->where('is_active', true)
            ->withCount([
                'workOrders as active_count' => function ($q) {
                    $q->where('status', WorkOrderStatus::InProgress);
                },
                'workOrders as pending_count' => function ($q) {
                    $q->whereIn('status', [WorkOrderStatus::Pending, WorkOrderStatus::Ready]);
                },
            ])
            ->orderBy('sort_order')
            ->get();

        return $workCenters->map(fn ($wc) => [
            'name' => $wc->name,
            'code' => $wc->code,
            'capacity' => $wc->capacity,
            'active' => $wc->active_count,
            'pending' => $wc->pending_count,
            'utilization' => $wc->capacity > 0 ? min(100, round(($wc->active_count / $wc->capacity) * 100)) : 0,
        ])->toArray();
    }

    public function getRecentlyCompleted(): array
    {
        return SfdWorkOrder::query()
            ->where('status', WorkOrderStatus::Done)
            ->with(['workCenter', 'manufacturingOrder', 'assignedUser'])
            ->orderByDesc('completed_at')
            ->limit(5)
            ->get()
            ->map(fn (SfdWorkOrder $wo) => [
                'name' => $wo->name,
                'mo_reference' => $wo->manufacturingOrder->reference,
                'work_center' => $wo->workCenter->name,
                'operator' => $wo->assignedUser?->name ?? __('sfd::widgets.production_status.unassigned'),
                'completed_at' => $wo->completed_at->diffForHumans(),
                'duration' => $wo->actual_duration,
                'expected' => $wo->expected_duration,
                'on_time' => $wo->actual_duration !== null && $wo->actual_duration <= $wo->expected_duration,
            ])
            ->toArray();
    }

    public function getSummaryStats(): array
    {
        $todayCompleted = SfdWorkOrder::query()
            ->where('status', WorkOrderStatus::Done)
            ->whereDate('completed_at', today())
            ->count();

        $totalActive = SfdWorkOrder::query()
            ->where('status', WorkOrderStatus::InProgress)
            ->count();

        $avgEfficiency = SfdWorkOrder::query()
            ->where('status', WorkOrderStatus::Done)
            ->whereNotNull('actual_duration')
            ->where('expected_duration', '>', 0)
            ->selectRaw('ROUND(AVG(expected_duration / actual_duration * 100)) as efficiency')
            ->value('efficiency') ?? 0;

        $overdueOrders = SfdManufacturingOrder::query()
            ->whereIn('status', [
                ManufacturingOrderStatus::Confirmed,
                ManufacturingOrderStatus::InProgress,
            ])
            ->whereNotNull('deadline')
            ->where('deadline', '<', today())
            ->count();

        return [
            'today_completed' => $todayCompleted,
            'active_work_orders' => $totalActive,
            'avg_efficiency' => (int) $avgEfficiency,
            'overdue_orders' => $overdueOrders,
        ];
    }
}
