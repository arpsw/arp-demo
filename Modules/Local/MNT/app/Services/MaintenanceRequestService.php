<?php

namespace Modules\MNT\Services;

use Modules\MNT\Enums\EquipmentStatus;
use Modules\MNT\Enums\MaintenanceStage;
use Modules\MNT\Models\MntMaintenanceRequest;

class MaintenanceRequestService
{
    public static function generateReference(): string
    {
        $latest = MntMaintenanceRequest::query()
            ->where('reference', 'like', 'MR-%')
            ->orderByDesc('reference')
            ->value('reference');

        if ($latest) {
            $number = (int) substr($latest, 3) + 1;
        } else {
            $number = 1;
        }

        return sprintf('MR-%04d', $number);
    }

    public function start(MntMaintenanceRequest $request): void
    {
        $request->update([
            'stage' => MaintenanceStage::InProgress,
        ]);

        if ($request->equipment) {
            $request->equipment->update([
                'status' => EquipmentStatus::Maintenance,
            ]);
        }
    }

    public function complete(MntMaintenanceRequest $request): void
    {
        $request->update([
            'stage' => MaintenanceStage::Repaired,
            'close_date' => now(),
        ]);

        if ($request->equipment) {
            $request->equipment->update([
                'status' => EquipmentStatus::Operational,
            ]);
        }
    }

    public function scrap(MntMaintenanceRequest $request): void
    {
        $request->update([
            'stage' => MaintenanceStage::Scrap,
            'close_date' => now(),
        ]);

        if ($request->equipment) {
            $request->equipment->update([
                'status' => EquipmentStatus::Retired,
            ]);
        }
    }
}
