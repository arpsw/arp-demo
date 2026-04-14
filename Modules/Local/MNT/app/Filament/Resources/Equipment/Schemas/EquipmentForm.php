<?php

namespace Modules\MNT\Filament\Resources\Equipment\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Modules\MNT\Enums\EquipmentStatus;

class EquipmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('mnt::forms.equipment.section_details'))
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('serial_number')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Select::make('category_id')
                            ->label(__('mnt::forms.equipment.category'))
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('work_center_id')
                            ->label(__('mnt::forms.equipment.work_center'))
                            ->relationship('workCenter', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('status')
                            ->options(EquipmentStatus::class)
                            ->default(EquipmentStatus::Operational)
                            ->required(),

                        TextInput::make('location')
                            ->maxLength(255),

                        TextInput::make('model')
                            ->label(__('mnt::forms.equipment.model'))
                            ->maxLength(255),

                        TextInput::make('manufacturer')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make(__('mnt::forms.equipment.section_ownership'))
                    ->schema([
                        Select::make('technician_id')
                            ->label(__('mnt::forms.equipment.responsible_technician'))
                            ->relationship('technician', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('owner_id')
                            ->label(__('mnt::forms.equipment.owner'))
                            ->relationship('owner', 'name')
                            ->searchable()
                            ->preload(),

                        DatePicker::make('purchase_date'),

                        DatePicker::make('warranty_expiry'),

                        TextInput::make('cost')
                            ->numeric()
                            ->prefix('EUR'),

                        DatePicker::make('effective_date')
                            ->label(__('mnt::forms.equipment.in_service_since')),

                        TextInput::make('expected_mtbf')
                            ->label(__('mnt::forms.equipment.expected_mtbf_days'))
                            ->numeric(),
                    ])
                    ->columns(2),

                Section::make(__('mnt::forms.equipment.section_notes'))
                    ->schema([
                        Textarea::make('notes')
                            ->columnSpanFull()
                            ->rows(3),
                    ])
                    ->collapsible(),
            ]);
    }
}
