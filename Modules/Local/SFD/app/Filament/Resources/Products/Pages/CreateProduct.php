<?php

namespace Modules\SFD\Filament\Resources\Products\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\SFD\Filament\Resources\Products\ProductResource;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
