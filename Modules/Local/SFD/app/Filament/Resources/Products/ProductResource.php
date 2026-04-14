<?php

namespace Modules\SFD\Filament\Resources\Products;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\SFD\Filament\Resources\Products\Pages\CreateProduct;
use Modules\SFD\Filament\Resources\Products\Pages\EditProduct;
use Modules\SFD\Filament\Resources\Products\Pages\ListProducts;
use Modules\SFD\Filament\Resources\Products\Pages\ViewProduct;
use Modules\SFD\Filament\Resources\Products\Schemas\ProductForm;
use Modules\SFD\Filament\Resources\Products\Tables\ProductsTable;
use Modules\SFD\Models\SfdProduct;

class ProductResource extends Resource
{
    protected static ?string $model = SfdProduct::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('sfd::resources.products.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('sfd::resources.products.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('sfd::resources.products.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sfd::resources.navigation_groups.master_data');
    }

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'view' => ViewProduct::route('/{record}'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
