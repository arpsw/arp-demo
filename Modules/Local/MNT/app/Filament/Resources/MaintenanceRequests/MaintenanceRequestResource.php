<?php

namespace Modules\MNT\Filament\Resources\MaintenanceRequests;

use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\MNT\Filament\Resources\MaintenanceRequests\Pages\CreateMaintenanceRequest;
use Modules\MNT\Filament\Resources\MaintenanceRequests\Pages\EditMaintenanceRequest;
use Modules\MNT\Filament\Resources\MaintenanceRequests\Pages\ListMaintenanceRequests;
use Modules\MNT\Filament\Resources\MaintenanceRequests\Pages\ViewMaintenanceRequest;
use Modules\MNT\Filament\Resources\MaintenanceRequests\Schemas\MaintenanceRequestForm;
use Modules\MNT\Filament\Resources\MaintenanceRequests\Tables\MaintenanceRequestsTable;
use Modules\MNT\Models\MntMaintenanceRequest;

class MaintenanceRequestResource extends Resource
{
    protected static ?string $model = MntMaintenanceRequest::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'reference';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('mnt::resources.maintenance_request.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('mnt::resources.maintenance_request.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('mnt::resources.maintenance_request.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('mnt::resources.maintenance_request.navigation_group');
    }

    public static function form(Schema $schema): Schema
    {
        return MaintenanceRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('mnt::pages.infolist.maintenance_request.section_details'))
                    ->schema([
                        TextEntry::make('reference'),
                        TextEntry::make('name'),
                        TextEntry::make('request_type')->badge(),
                        TextEntry::make('priority')->badge(),
                        TextEntry::make('stage')->badge(),
                        TextEntry::make('equipment.name')->label(__('mnt::pages.infolist.maintenance_request.equipment'))->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('category.name')->label(__('mnt::pages.infolist.maintenance_request.category'))->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('team.name')->label(__('mnt::pages.infolist.maintenance_request.team'))->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('technician.name')->label(__('mnt::pages.infolist.maintenance_request.technician'))->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('requestedBy.name')->label(__('mnt::pages.infolist.maintenance_request.requested_by'))->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('scheduled_date')->date()->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('close_date')->date()->placeholder(__('mnt::tables.placeholders.dash')),
                        TextEntry::make('duration')->suffix(' hours')->placeholder(__('mnt::tables.placeholders.dash')),
                    ])
                    ->columns(3),

                Section::make(__('mnt::pages.infolist.maintenance_request.section_description'))
                    ->schema([
                        TextEntry::make('description')->placeholder(__('mnt::tables.placeholders.dash')),
                    ])
                    ->collapsible(),

                Section::make(__('mnt::pages.infolist.maintenance_request.section_notes'))
                    ->schema([
                        TextEntry::make('notes')->placeholder(__('mnt::tables.placeholders.dash')),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return MaintenanceRequestsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMaintenanceRequests::route('/'),
            'create' => CreateMaintenanceRequest::route('/create'),
            'view' => ViewMaintenanceRequest::route('/{record}'),
            'edit' => EditMaintenanceRequest::route('/{record}/edit'),
        ];
    }
}
