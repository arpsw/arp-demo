<?php

namespace Modules\MNT\Filament\Resources\Equipment\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\MNT\Enums\MaintenancePriority;
use Modules\MNT\Enums\MaintenanceRequestType;
use Modules\MNT\Enums\MaintenanceStage;
use Modules\MNT\Services\MaintenanceRequestService;

class MaintenanceRequestsRelationManager extends RelationManager
{
    protected static string $relationship = 'maintenanceRequests';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reference')
                    ->default(fn () => MaintenanceRequestService::generateReference())
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Select::make('request_type')
                    ->options(MaintenanceRequestType::class)
                    ->default(MaintenanceRequestType::Corrective)
                    ->required(),

                Select::make('priority')
                    ->options(MaintenancePriority::class)
                    ->default(MaintenancePriority::Normal)
                    ->required(),

                Select::make('stage')
                    ->options(MaintenanceStage::class)
                    ->default(MaintenanceStage::New)
                    ->required(),

                Select::make('team_id')
                    ->label(__('mnt::forms.relation_managers.maintenance_requests.team'))
                    ->relationship('team', 'name')
                    ->searchable()
                    ->preload(),

                Select::make('technician_id')
                    ->label(__('mnt::forms.relation_managers.maintenance_requests.technician'))
                    ->relationship('technician', 'name')
                    ->searchable()
                    ->preload(),

                DatePicker::make('scheduled_date'),

                Textarea::make('description')
                    ->columnSpanFull()
                    ->rows(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('name')
                    ->searchable()
                    ->limit(30),

                TextColumn::make('request_type')
                    ->badge(),

                TextColumn::make('priority')
                    ->badge(),

                TextColumn::make('stage')
                    ->badge(),

                TextColumn::make('scheduled_date')
                    ->date()
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
