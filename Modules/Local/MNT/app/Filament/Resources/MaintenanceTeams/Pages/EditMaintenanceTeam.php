<?php

namespace Modules\MNT\Filament\Resources\MaintenanceTeams\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Modules\MNT\Filament\Resources\MaintenanceTeams\MaintenanceTeamResource;

class EditMaintenanceTeam extends EditRecord
{
    protected static string $resource = MaintenanceTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
