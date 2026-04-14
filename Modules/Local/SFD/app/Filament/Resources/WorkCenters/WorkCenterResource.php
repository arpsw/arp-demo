<?php

namespace Modules\SFD\Filament\Resources\WorkCenters;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\SFD\Filament\Resources\WorkCenters\Pages\CreateWorkCenter;
use Modules\SFD\Filament\Resources\WorkCenters\Pages\EditWorkCenter;
use Modules\SFD\Filament\Resources\WorkCenters\Pages\ListWorkCenters;
use Modules\SFD\Filament\Resources\WorkCenters\Pages\ViewWorkCenter;
use Modules\SFD\Filament\Resources\WorkCenters\RelationManagers\EquipmentRelationManager;
use Modules\SFD\Filament\Resources\WorkCenters\Schemas\WorkCenterForm;
use Modules\SFD\Filament\Resources\WorkCenters\Tables\WorkCentersTable;
use Modules\SFD\Models\SfdWorkCenter;

class WorkCenterResource extends Resource
{
    protected static ?string $model = SfdWorkCenter::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('sfd::resources.work_centers.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('sfd::resources.work_centers.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('sfd::resources.work_centers.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sfd::resources.navigation_groups.master_data');
    }

    public static function form(Schema $schema): Schema
    {
        return WorkCenterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkCentersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            EquipmentRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWorkCenters::route('/'),
            'create' => CreateWorkCenter::route('/create'),
            'view' => ViewWorkCenter::route('/{record}'),
            'edit' => EditWorkCenter::route('/{record}/edit'),
        ];
    }
}
