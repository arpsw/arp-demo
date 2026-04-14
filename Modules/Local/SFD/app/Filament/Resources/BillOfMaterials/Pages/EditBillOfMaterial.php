<?php

namespace Modules\SFD\Filament\Resources\BillOfMaterials\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Modules\SFD\Filament\Resources\BillOfMaterials\BillOfMaterialResource;

class EditBillOfMaterial extends EditRecord
{
    protected static string $resource = BillOfMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
