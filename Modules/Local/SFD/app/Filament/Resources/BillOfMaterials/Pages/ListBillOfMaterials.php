<?php

namespace Modules\SFD\Filament\Resources\BillOfMaterials\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\SFD\Filament\Resources\BillOfMaterials\BillOfMaterialResource;

class ListBillOfMaterials extends ListRecords
{
    protected static string $resource = BillOfMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
