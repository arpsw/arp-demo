<?php

namespace Modules\MNT\Services;

use Illuminate\Support\Collection;
use Modules\MNT\Enums\MaintenanceRequestType;
use Modules\MNT\Enums\MaintenanceStage;
use Modules\MNT\Models\MntMaintenanceRequest;
use Modules\MNT\Models\MntPreventiveSchedule;

class PreventiveMaintenanceService
{
    public function generateDueRequests(): Collection
    {
        $dueSchedules = MntPreventiveSchedule::query()
            ->where('is_active', true)
            ->where('next_date', '<=', now()->toDateString())
            ->with(['equipment', 'team', 'technician'])
            ->get();

        $generated = collect();

        foreach ($dueSchedules as $schedule) {
            $request = $this->generateRequest($schedule);
            $generated->push($request);
        }

        return $generated;
    }

    public function generateRequest(MntPreventiveSchedule $schedule): MntMaintenanceRequest
    {
        $request = MntMaintenanceRequest::create([
            'reference' => MaintenanceRequestService::generateReference(),
            'name' => $schedule->name,
            'equipment_id' => $schedule->equipment_id,
            'category_id' => $schedule->equipment?->category_id,
            'request_type' => MaintenanceRequestType::Preventive,
            'priority' => $schedule->priority,
            'stage' => MaintenanceStage::New,
            'team_id' => $schedule->team_id,
            'technician_id' => $schedule->technician_id,
            'scheduled_date' => $schedule->next_date,
            'description' => $schedule->description,
        ]);

        $schedule->update([
            'last_generated_date' => now()->toDateString(),
            'next_date' => now()->addDays($schedule->frequency_days)->toDateString(),
        ]);

        return $request;
    }
}
