<?php

namespace Modules\MNT\Filament\Resources\MaintenanceRequests\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\MNT\Filament\Resources\MaintenanceRequests\MaintenanceRequestResource;

class CreateMaintenanceRequest extends CreateRecord
{
    protected static string $resource = MaintenanceRequestResource::class;
}
