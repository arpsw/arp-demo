<?php

namespace Modules\SFD\Filament\Resources\ManufacturingOrders\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Modules\SFD\Filament\Resources\ManufacturingOrders\ManufacturingOrderResource;

class EditManufacturingOrder extends EditRecord
{
    protected static string $resource = ManufacturingOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
