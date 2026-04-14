<?php

namespace Modules\SFD\Filament\Resources\ManufacturingOrders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Modules\SFD\Enums\ManufacturingOrderPriority;
use Modules\SFD\Enums\ManufacturingOrderStatus;
use Modules\SFD\Models\SfdBillOfMaterial;
use Modules\SFD\Services\ManufacturingOrderService;

class ManufacturingOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('sfd::forms.sections.order_details'))
                    ->schema([
                        TextInput::make('reference')
                            ->default(fn () => ManufacturingOrderService::generateReference())
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),

                        Select::make('product_id')
                            ->label(__('sfd::forms.fields.product'))
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live(),

                        Select::make('bom_id')
                            ->label(__('sfd::forms.fields.bill_of_material'))
                            ->options(fn (Get $get) => SfdBillOfMaterial::query()
                                ->where('product_id', $get('product_id'))
                                ->where('is_active', true)
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->required(),

                        TextInput::make('quantity')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->default(1),

                        Select::make('status')
                            ->options(ManufacturingOrderStatus::class)
                            ->default(ManufacturingOrderStatus::Draft)
                            ->required()
                            ->visibleOn('edit'),

                        Select::make('priority')
                            ->options(ManufacturingOrderPriority::class)
                            ->default(ManufacturingOrderPriority::Normal)
                            ->required(),

                        DatePicker::make('scheduled_date'),

                        DatePicker::make('deadline'),

                        Textarea::make('notes')
                            ->columnSpanFull()
                            ->rows(3),
                    ])
                    ->columns(2),
            ]);
    }
}
