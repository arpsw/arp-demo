<?php

namespace Modules\MNT\Filament\Resources\Equipment\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\MNT\Enums\MaintenancePriority;

class PreventiveSchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'preventiveSchedules';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('frequency_days')
                    ->label(__('mnt::forms.relation_managers.preventive_schedules.frequency_days'))
                    ->numeric()
                    ->required()
                    ->minValue(1),

                Select::make('team_id')
                    ->label(__('mnt::forms.relation_managers.preventive_schedules.team'))
                    ->relationship('team', 'name')
                    ->searchable()
                    ->preload(),

                Select::make('technician_id')
                    ->label(__('mnt::forms.relation_managers.preventive_schedules.technician'))
                    ->relationship('technician', 'name')
                    ->searchable()
                    ->preload(),

                Select::make('priority')
                    ->options(MaintenancePriority::class)
                    ->default(MaintenancePriority::Normal)
                    ->required(),

                DatePicker::make('next_date')
                    ->label(__('mnt::forms.relation_managers.preventive_schedules.next_scheduled_date')),

                Toggle::make('is_active')
                    ->default(true),

                Textarea::make('description')
                    ->columnSpanFull()
                    ->rows(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('frequency_days')
                    ->label(__('mnt::tables.relation_managers.preventive_schedules.every_days'))
                    ->sortable(),

                TextColumn::make('priority')
                    ->badge(),

                TextColumn::make('next_date')
                    ->date()
                    ->label(__('mnt::tables.relation_managers.preventive_schedules.next_date'))
                    ->sortable(),

                TextColumn::make('last_generated_date')
                    ->date()
                    ->label(__('mnt::tables.relation_managers.preventive_schedules.last_generated'))
                    ->placeholder(__('mnt::tables.placeholders.never')),

                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('next_date');
    }
}
