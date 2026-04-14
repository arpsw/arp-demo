<?php

namespace Modules\MNT\Filament\Resources\MaintenanceTeams\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\MNT\Filament\Resources\MaintenanceTeams\MaintenanceTeamResource;

class ListMaintenanceTeams extends ListRecords
{
    protected static string $resource = MaintenanceTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
