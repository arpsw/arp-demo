<?php

namespace Modules\MNT\Filament\Resources\Equipment\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Modules\MNT\Filament\Resources\Equipment\EquipmentResource;

class ViewEquipment extends ViewRecord
{
    protected static string $resource = EquipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
