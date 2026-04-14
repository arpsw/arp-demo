<?php

namespace Modules\MNT\Filament\Resources\PreventiveSchedules\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\MNT\Filament\Resources\PreventiveSchedules\PreventiveScheduleResource;

class ListPreventiveSchedules extends ListRecords
{
    protected static string $resource = PreventiveScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
