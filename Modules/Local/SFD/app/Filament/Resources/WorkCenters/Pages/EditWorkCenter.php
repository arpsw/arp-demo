<?php

namespace Modules\SFD\Filament\Resources\WorkCenters\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Modules\SFD\Filament\Resources\WorkCenters\WorkCenterResource;

class EditWorkCenter extends EditRecord
{
    protected static string $resource = WorkCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
