<?php

namespace Modules\MNT\Filament\Resources\EquipmentCategories\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EquipmentCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('mnt::forms.equipment_category.section_details'))
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        ColorPicker::make('color'),

                        Textarea::make('notes')
                            ->columnSpanFull()
                            ->rows(3),
                    ])
                    ->columns(2),
            ]);
    }
}
