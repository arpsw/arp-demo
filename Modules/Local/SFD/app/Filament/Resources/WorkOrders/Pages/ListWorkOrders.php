<?php

namespace Modules\SFD\Filament\Resources\WorkOrders\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\SFD\Filament\Resources\WorkOrders\WorkOrderResource;

class ListWorkOrders extends ListRecords
{
    protected static string $resource = WorkOrderResource::class;
}
