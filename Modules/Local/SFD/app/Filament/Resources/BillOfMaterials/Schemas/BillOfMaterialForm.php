<?php

namespace Modules\SFD\Filament\Resources\BillOfMaterials\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Modules\SFD\Enums\ProductType;
use Modules\SFD\Models\SfdProduct;
use Modules\SFD\Models\SfdWorkCenter;

class BillOfMaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('sfd::forms.sections.bom_details'))
                    ->schema([
                        Select::make('product_id')
                            ->label(__('sfd::forms.fields.product'))
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('quantity')
                            ->numeric()
                            ->default(1)
                            ->minValue(0.01)
                            ->step(0.01)
                            ->required(),

                        Toggle::make('is_active')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make(__('sfd::forms.sections.components'))
                    ->schema([
                        Repeater::make('components')
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->label(__('sfd::forms.fields.component'))
                                    ->options(fn () => SfdProduct::query()
                                        ->whereIn('type', [ProductType::RawMaterial, ProductType::SubAssembly])
                                        ->pluck('name', 'id'))
                                    ->searchable()
                                    ->required(),

                                TextInput::make('quantity')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0.001)
                                    ->step(0.001)
                                    ->default(1),

                                TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->columns(3)
                            ->reorderable()
                            ->orderColumn('sort_order')
                            ->collapsible()
                            ->defaultItems(0)
                            ->itemLabel(fn (array $state): ?string => SfdProduct::find($state['product_id'] ?? null)?->name),
                    ]),

                Section::make(__('sfd::forms.sections.operations_routing'))
                    ->schema([
                        Repeater::make('operations')
                            ->relationship()
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),

                                Select::make('work_center_id')
                                    ->label(__('sfd::forms.fields.work_center'))
                                    ->options(fn () => SfdWorkCenter::query()
                                        ->where('is_active', true)
                                        ->pluck('name', 'id'))
                                    ->searchable()
                                    ->required(),

                                TextInput::make('duration_minutes')
                                    ->numeric()
                                    ->required()
                                    ->suffix('min')
                                    ->minValue(1),

                                Textarea::make('description')
                                    ->rows(2)
                                    ->columnSpanFull(),

                                TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->columns(3)
                            ->reorderable()
                            ->orderColumn('sort_order')
                            ->collapsible()
                            ->defaultItems(0)
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null),
                    ]),
            ]);
    }
}
