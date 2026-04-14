<?php

namespace Modules\SFD\Filament\Resources\BillOfMaterials;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\SFD\Filament\Resources\BillOfMaterials\Pages\CreateBillOfMaterial;
use Modules\SFD\Filament\Resources\BillOfMaterials\Pages\EditBillOfMaterial;
use Modules\SFD\Filament\Resources\BillOfMaterials\Pages\ListBillOfMaterials;
use Modules\SFD\Filament\Resources\BillOfMaterials\Pages\ViewBillOfMaterial;
use Modules\SFD\Filament\Resources\BillOfMaterials\Schemas\BillOfMaterialForm;
use Modules\SFD\Filament\Resources\BillOfMaterials\Tables\BillOfMaterialsTable;
use Modules\SFD\Models\SfdBillOfMaterial;

class BillOfMaterialResource extends Resource
{
    protected static ?string $model = SfdBillOfMaterial::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('sfd::resources.bill_of_materials.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('sfd::resources.bill_of_materials.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('sfd::resources.bill_of_materials.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sfd::resources.navigation_groups.master_data');
    }

    public static function form(Schema $schema): Schema
    {
        return BillOfMaterialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BillOfMaterialsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBillOfMaterials::route('/'),
            'create' => CreateBillOfMaterial::route('/create'),
            'view' => ViewBillOfMaterial::route('/{record}'),
            'edit' => EditBillOfMaterial::route('/{record}/edit'),
        ];
    }
}
