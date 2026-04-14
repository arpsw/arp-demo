<?php

namespace Modules\MNT\Filament\Resources\EquipmentCategories\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\MNT\Filament\Resources\EquipmentCategories\EquipmentCategoryResource;

class CreateEquipmentCategory extends CreateRecord
{
    protected static string $resource = EquipmentCategoryResource::class;
}
