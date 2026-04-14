<?php

namespace Modules\MNT\Filament\Resources\EquipmentCategories;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\MNT\Filament\Resources\EquipmentCategories\Pages\CreateEquipmentCategory;
use Modules\MNT\Filament\Resources\EquipmentCategories\Pages\EditEquipmentCategory;
use Modules\MNT\Filament\Resources\EquipmentCategories\Pages\ListEquipmentCategories;
use Modules\MNT\Filament\Resources\EquipmentCategories\Schemas\EquipmentCategoryForm;
use Modules\MNT\Filament\Resources\EquipmentCategories\Tables\EquipmentCategoriesTable;
use Modules\MNT\Models\MntEquipmentCategory;

class EquipmentCategoryResource extends Resource
{
    protected static ?string $model = MntEquipmentCategory::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    public static function getModelLabel(): string
    {
        return __('mnt::resources.equipment_category.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('mnt::resources.equipment_category.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('mnt::resources.equipment_category.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('mnt::resources.equipment_category.navigation_group');
    }

    public static function form(Schema $schema): Schema
    {
        return EquipmentCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EquipmentCategoriesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEquipmentCategories::route('/'),
            'create' => CreateEquipmentCategory::route('/create'),
            'edit' => EditEquipmentCategory::route('/{record}/edit'),
        ];
    }
}
