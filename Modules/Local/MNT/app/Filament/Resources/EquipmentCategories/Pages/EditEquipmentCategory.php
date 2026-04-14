<?php

namespace Modules\MNT\Filament\Resources\EquipmentCategories\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Modules\MNT\Filament\Resources\EquipmentCategories\EquipmentCategoryResource;

class EditEquipmentCategory extends EditRecord
{
    protected static string $resource = EquipmentCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
