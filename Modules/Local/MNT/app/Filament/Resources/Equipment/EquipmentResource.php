<?php

namespace Modules\MNT\Filament\Resources\Equipment;

use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\MNT\Filament\Resources\Equipment\Pages\CreateEquipment;
use Modules\MNT\Filament\Resources\Equipment\Pages\EditEquipment;
use Modules\MNT\Filament\Resources\Equipment\Pages\ListEquipment;
use Modules\MNT\Filament\Resources\Equipment\Pages\ViewEquipment;
use Modules\MNT\Filament\Resources\Equipment\RelationManagers\MaintenanceRequestsRelationManager;
use Modules\MNT\Filament\Resources\Equipment\RelationManagers\PreventiveSchedulesRelationManager;
use Modules\MNT\Filament\Resources\Equipment\Schemas\EquipmentForm;
use Modules\MNT\Filament\Resources\Equipment\Tables\EquipmentTable;
use Modules\MNT\Models\MntEquipment;

class EquipmentResource extends Resource
{
    protected static ?string $model = MntEquipment::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('mnt::resources.equipment.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('mnt::resources.equipment.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('mnt::resources.equipment.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('mnt::resources.equipment.navigation_group');
    }

    public static function form(Schema $schema): Schema
    {
        return EquipmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('mnt::pages.infolist.equipment.section_details'))
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('serial_number')->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('category.name')->label(__('mnt::pages.infolist.equipment.category'))->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('workCenter.name')->label(__('mnt::pages.infolist.equipment.work_center'))->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('status')->badge(),
                        TextEntry::make('location')->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('model')->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('manufacturer')->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('purchase_date')->date()->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('warranty_expiry')->date()->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('cost')->money('EUR')->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('effective_date')->date()->label(__('mnt::pages.infolist.equipment.in_service_since'))->placeholder(__('mnt::tables.placeholders.dash')),
                    ])
                    ->columns(3),

                Section::make(__('mnt::pages.infolist.equipment.section_personnel'))
                    ->schema([
                        TextEntry::make('technician.name')->label(__('mnt::pages.infolist.equipment.technician'))->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('owner.name')->label(__('mnt::pages.infolist.equipment.owner'))->placeholder(__('mnt::tables.placeholders.dash')),
                    ])
                    ->columns(2),

                Section::make(__('mnt::pages.infolist.equipment.section_statistics'))
                    ->schema([
                        TextEntry::make('mtbf')->label(__('mnt::pages.infolist.equipment.mtbf_days'))->placeholder(__('mnt::tables.placeholders.not_computed')),
                        TextEntry::make('mttr')->label(__('mnt::pages.infolist.equipment.mttr_hours'))->placeholder(__('mnt::tables.placeholders.not_computed')),
                        TextEntry::make('expected_mtbf')->label(__('mnt::pages.infolist.equipment.expected_mtbf_days'))->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('latest_failure_date')->date()->label(__('mnt::pages.infolist.equipment.last_failure'))->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('next_preventive_date')->date()->label(__('mnt::pages.infolist.equipment.next_preventive'))->placeholder(__('mnt::tables.placeholders.dash')),
                    ])
                    ->columns(3),

                Section::make(__('mnt::pages.infolist.equipment.section_notes'))
                    ->schema([
                        TextEntry::make('notes')->placeholder(__('mnt::tables.placeholders.dash')),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return EquipmentTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            MaintenanceRequestsRelationManager::class,
            PreventiveSchedulesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEquipment::route('/'),
            'create' => CreateEquipment::route('/create'),
            'view' => ViewEquipment::route('/{record}'),
            'edit' => EditEquipment::route('/{record}/edit'),
        ];
    }
}
