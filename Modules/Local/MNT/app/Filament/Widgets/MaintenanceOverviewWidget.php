<?php

namespace Modules\MNT\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Collection;
use Modules\MNT\Enums\EquipmentStatus;
use Modules\MNT\Enums\MaintenanceStage;
use Modules\MNT\Models\MntEquipment;
use Modules\MNT\Models\MntMaintenanceRequest;
use Modules\MNT\Models\MntPreventiveSchedule;

class MaintenanceOverviewWidget extends Widget
{
    protected string $view = 'mnt::filament.widgets.maintenance-overview';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = -1;

    public function getStats(): array
    {
        return [
            'pending' => MntMaintenanceRequest::where('stage', MaintenanceStage::New)->count(),
            'in_progress' => MntMaintenanceRequest::where('stage', MaintenanceStage::InProgress)->count(),
            'completed_this_month' => MntMaintenanceRequest::where('stage', MaintenanceStage::Repaired)
                ->whereMonth('close_date', now()->month)
                ->whereYear('close_date', now()->year)
                ->count(),
            'equipment_needing_attention' => MntEquipment::whereIn('status', [
                EquipmentStatus::Maintenance,
                EquipmentStatus::OutOfService,
            ])->count(),
        ];
    }

    public function getUpcomingPreventive(): Collection
    {
        return MntPreventiveSchedule::query()
            ->where('is_active', true)
            ->where('next_date', '<=', now()->addDays(7))
            ->with('equipment')
            ->orderBy('next_date')
            ->limit(5)
            ->get();
    }

    public function getRecentActivity(): Collection
    {
        return MntMaintenanceRequest::query()
            ->with(['equipment', 'technician'])
            ->orderByDesc('updated_at')
            ->limit(5)
            ->get();
    }

    public function getEquipmentDistribution(): array
    {
        $counts = [];
        foreach (EquipmentStatus::cases() as $status) {
            $counts[$status->getLabel()] = MntEquipment::where('status', $status)->count();
        }

        return $counts;
    }
}
