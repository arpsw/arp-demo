<?php

namespace Modules\SFD\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Modules\SFD\Enums\ProductType;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('sfd::forms.sections.product_details'))
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('sku')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),

                        Select::make('type')
                            ->options(ProductType::class)
                            ->required()
                            ->default(ProductType::RawMaterial),

                        TextInput::make('unit_cost')
                            ->numeric()
                            ->prefix('€')
                            ->step(0.01),

                        Textarea::make('description')
                            ->columnSpanFull()
                            ->rows(3),

                        TextInput::make('image_url')
                            ->url()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
