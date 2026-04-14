<?php

namespace Modules\MNT\Filament\Resources\EquipmentCategories\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\MNT\Filament\Resources\EquipmentCategories\EquipmentCategoryResource;

class ListEquipmentCategories extends ListRecords
{
    protected static string $resource = EquipmentCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
