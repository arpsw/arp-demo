<?php

namespace Modules\MNT\Filament\Resources\PreventiveSchedules\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Modules\MNT\Filament\Resources\PreventiveSchedules\PreventiveScheduleResource;

class EditPreventiveSchedule extends EditRecord
{
    protected static string $resource = PreventiveScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
