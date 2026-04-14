<?php

namespace Modules\SFD\Filament\Resources\ManufacturingOrders\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\SFD\Filament\Resources\ManufacturingOrders\ManufacturingOrderResource;

class CreateManufacturingOrder extends CreateRecord
{
    protected static string $resource = ManufacturingOrderResource::class;
}
