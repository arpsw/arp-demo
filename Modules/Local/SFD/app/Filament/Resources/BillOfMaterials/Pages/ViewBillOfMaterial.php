<?php

namespace Modules\SFD\Filament\Resources\BillOfMaterials\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Modules\SFD\Filament\Resources\BillOfMaterials\BillOfMaterialResource;

class ViewBillOfMaterial extends ViewRecord
{
    protected static string $resource = BillOfMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
