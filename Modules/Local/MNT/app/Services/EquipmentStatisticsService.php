<?php

namespace Modules\MNT\Services;

use Modules\MNT\Enums\MaintenanceRequestType;
use Modules\MNT\Enums\MaintenanceStage;
use Modules\MNT\Models\MntEquipment;
use Modules\MNT\Models\MntMaintenanceRequest;

class EquipmentStatisticsService
{
    public function computeStatistics(MntEquipment $equipment): void
    {
        $mtbf = $this->computeMTBF($equipment);
        $mttr = $this->computeMTTR($equipment);

        $latestFailure = MntMaintenanceRequest::query()
            ->where('equipment_id', $equipment->id)
            ->where('request_type', MaintenanceRequestType::Corrective)
            ->whereNotNull('close_date')
            ->orderByDesc('close_date')
            ->value('close_date');

        $equipment->update([
            'mtbf' => $mtbf,
            'mttr' => $mttr,
            'latest_failure_date' => $latestFailure,
        ]);
    }

    private function computeMTBF(MntEquipment $equipment): ?int
    {
        $failures = MntMaintenanceRequest::query()
            ->where('equipment_id', $equipment->id)
            ->where('request_type', MaintenanceRequestType::Corrective)
            ->whereNotNull('close_date')
            ->orderBy('close_date')
            ->pluck('close_date');

        if ($failures->count() < 2) {
            return null;
        }

        $totalDays = 0;
        for ($i = 1; $i < $failures->count(); $i++) {
            $totalDays += $failures[$i - 1]->diffInDays($failures[$i]);
        }

        return (int) round($totalDays / ($failures->count() - 1));
    }

    private function computeMTTR(MntEquipment $equipment): ?int
    {
        $repairs = MntMaintenanceRequest::query()
            ->where('equipment_id', $equipment->id)
            ->where('stage', MaintenanceStage::Repaired)
            ->whereNotNull('duration')
            ->where('duration', '>', 0)
            ->pluck('duration');

        if ($repairs->isEmpty()) {
            return null;
        }

        return (int) round($repairs->avg());
    }
}
