<?php

namespace Modules\SFD\Filament\Resources\WorkCenters\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\SFD\Filament\Resources\WorkCenters\WorkCenterResource;

class ListWorkCenters extends ListRecords
{
    protected static string $resource = WorkCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
