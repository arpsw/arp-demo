<?php

namespace Modules\SFD\Filament\Resources\ManufacturingOrders\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\SFD\Filament\Resources\ManufacturingOrders\ManufacturingOrderResource;

class ListManufacturingOrders extends ListRecords
{
    protected static string $resource = ManufacturingOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
