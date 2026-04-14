<?php

namespace Modules\MNT\Filament\Resources\MaintenanceRequests\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\MNT\Filament\Resources\MaintenanceRequests\MaintenanceRequestResource;

class ListMaintenanceRequests extends ListRecords
{
    protected static string $resource = MaintenanceRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
