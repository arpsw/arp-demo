<?php

namespace Modules\SFD\Filament\Resources\WorkOrders;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\MNT\Filament\Resources\Equipment\EquipmentResource;
use Modules\SFD\Filament\Resources\ManufacturingOrders\ManufacturingOrderResource;
use Modules\SFD\Filament\Resources\WorkCenters\WorkCenterResource;
use Modules\SFD\Filament\Resources\WorkOrders\Pages\ListWorkOrders;
use Modules\SFD\Filament\Resources\WorkOrders\Pages\ViewWorkOrder;
use Modules\SFD\Filament\Resources\WorkOrders\Tables\WorkOrdersTable;
use Modules\SFD\Models\SfdWorkOrder;

class WorkOrderResource extends Resource
{
    protected static ?string $model = SfdWorkOrder::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('sfd::resources.work_orders.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('sfd::resources.work_orders.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('sfd::resources.work_orders.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sfd::resources.navigation_groups.production');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('sfd::pages.infolist.work_order_details'))
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('manufacturingOrder.reference')
                            ->label(__('sfd::pages.infolist.mo_reference'))
                            ->url(fn ($record) => $record->manufacturing_order_id
                                ? ManufacturingOrderResource::getUrl('view', ['record' => $record->manufacturing_order_id])
                                : null)
                            ->color('primary'),
                        TextEntry::make('status')->badge(),
                        TextEntry::make('expected_duration')->suffix(' min'),
                        TextEntry::make('actual_duration')->suffix(' min')->placeholder(__('sfd::tables.placeholders.dash')),
                        TextEntry::make('assignedUser.name')->label(__('sfd::pages.infolist.operator'))->placeholder(__('sfd::tables.placeholders.unassigned')),
                        TextEntry::make('started_at')->dateTime(),
                        TextEntry::make('completed_at')->dateTime(),
                        TextEntry::make('notes')->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                Section::make(__('sfd::pages.infolist.work_center'))
                    ->schema([
                        TextEntry::make('workCenter.name')
                            ->label(__('sfd::pages.infolist.work_center_name'))
                            ->url(fn ($record) => $record->work_center_id
                                ? WorkCenterResource::getUrl('view', ['record' => $record->work_center_id])
                                : null)
                            ->color('primary'),
                        TextEntry::make('workCenter.code')->label(__('sfd::pages.infolist.work_center_code')),
                        TextEntry::make('workCenter.capacity')->label(__('sfd::pages.infolist.work_center_capacity')),
                        TextEntry::make('workCenter.cost_per_hour')->label(__('sfd::pages.infolist.work_center_cost'))->money('EUR'),

                        RepeatableEntry::make('workCenter.equipment')
                            ->label(__('sfd::pages.infolist.equipment_at_work_center'))
                            ->schema([
                                TextEntry::make('name')
                                    ->label(__('sfd::pages.infolist.equipment_name'))
                                    ->url(fn ($record) => EquipmentResource::getUrl('view', ['record' => $record->id], panel: 'mnt'))
                                    ->color('primary'),
                                TextEntry::make('serial_number')->label(__('sfd::pages.infolist.equipment_serial')),
                                TextEntry::make('category.name')->label(__('sfd::pages.infolist.equipment_category')),
                                TextEntry::make('status')->badge()->label(__('sfd::pages.infolist.equipment_status')),
                                TextEntry::make('manufacturer')->label(__('sfd::pages.infolist.equipment_manufacturer'))->placeholder(__('sfd::tables.placeholders.dash')),
                            ])
                            ->columns(5)
                            ->columnSpanFull(),
                    ])
                    ->columns(4)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return WorkOrdersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWorkOrders::route('/'),
            'view' => ViewWorkOrder::route('/{record}'),
        ];
    }
}
