<?php

namespace Modules\SFD\Filament\Resources\WorkCenters\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Modules\SFD\Filament\Resources\WorkCenters\WorkCenterResource;

class ViewWorkCenter extends ViewRecord
{
    protected static string $resource = WorkCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
