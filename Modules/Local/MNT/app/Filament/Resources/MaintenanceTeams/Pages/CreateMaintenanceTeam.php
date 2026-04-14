<?php

namespace Modules\MNT\Filament\Resources\MaintenanceTeams\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\MNT\Filament\Resources\MaintenanceTeams\MaintenanceTeamResource;

class CreateMaintenanceTeam extends CreateRecord
{
    protected static string $resource = MaintenanceTeamResource::class;
}
