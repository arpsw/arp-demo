<?php

namespace Modules\MNT\Filament\Resources\PreventiveSchedules\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Modules\MNT\Enums\MaintenancePriority;

class PreventiveScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('mnt::forms.preventive_schedule.section_details'))
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Select::make('equipment_id')
                            ->label(__('mnt::forms.preventive_schedule.equipment'))
                            ->relationship('equipment', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('frequency_days')
                            ->label(__('mnt::forms.preventive_schedule.frequency_days'))
                            ->numeric()
                            ->required()
                            ->minValue(1),

                        Select::make('priority')
                            ->options(MaintenancePriority::class)
                            ->default(MaintenancePriority::Normal)
                            ->required(),

                        Select::make('team_id')
                            ->label(__('mnt::forms.preventive_schedule.maintenance_team'))
                            ->relationship('team', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('technician_id')
                            ->label(__('mnt::forms.preventive_schedule.default_technician'))
                            ->relationship('technician', 'name')
                            ->searchable()
                            ->preload(),

                        DatePicker::make('next_date')
                            ->label(__('mnt::forms.preventive_schedule.next_scheduled_date')),

                        Toggle::make('is_active')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make(__('mnt::forms.preventive_schedule.section_instructions'))
                    ->schema([
                        Textarea::make('description')
                            ->label(__('mnt::forms.preventive_schedule.maintenance_instructions'))
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
