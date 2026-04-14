<?php

namespace Modules\SFD\Filament\Resources\ManufacturingOrders;

use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\SFD\Filament\Resources\ManufacturingOrders\Pages\CreateManufacturingOrder;
use Modules\SFD\Filament\Resources\ManufacturingOrders\Pages\EditManufacturingOrder;
use Modules\SFD\Filament\Resources\ManufacturingOrders\Pages\ListManufacturingOrders;
use Modules\SFD\Filament\Resources\ManufacturingOrders\Pages\ViewManufacturingOrder;
use Modules\SFD\Filament\Resources\ManufacturingOrders\RelationManagers\WorkOrdersRelationManager;
use Modules\SFD\Filament\Resources\ManufacturingOrders\Schemas\ManufacturingOrderForm;
use Modules\SFD\Filament\Resources\ManufacturingOrders\Tables\ManufacturingOrdersTable;
use Modules\SFD\Models\SfdManufacturingOrder;

class ManufacturingOrderResource extends Resource
{
    protected static ?string $model = SfdManufacturingOrder::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $recordTitleAttribute = 'reference';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('sfd::resources.manufacturing_orders.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('sfd::resources.manufacturing_orders.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('sfd::resources.manufacturing_orders.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sfd::resources.navigation_groups.production');
    }

    public static function form(Schema $schema): Schema
    {
        return ManufacturingOrderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('sfd::pages.infolist.order_details'))
                    ->schema([
                        TextEntry::make('reference'),
                        TextEntry::make('product.name'),
                        TextEntry::make('billOfMaterial.name')->label(__('sfd::pages.infolist.bom')),
                        TextEntry::make('quantity'),
                        TextEntry::make('status')->badge(),
                        TextEntry::make('priority')->badge(),
                        TextEntry::make('scheduled_date')->date(),
                        TextEntry::make('deadline')->date(),
                        TextEntry::make('completed_at')->dateTime(),
                        TextEntry::make('notes')->columnSpanFull(),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return ManufacturingOrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            WorkOrdersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListManufacturingOrders::route('/'),
            'create' => CreateManufacturingOrder::route('/create'),
            'view' => ViewManufacturingOrder::route('/{record}'),
            'edit' => EditManufacturingOrder::route('/{record}/edit'),
        ];
    }
}
