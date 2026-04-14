<?php

namespace Modules\MNT\Filament\Resources\MaintenanceRequests\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Modules\MNT\Enums\MaintenancePriority;
use Modules\MNT\Enums\MaintenanceRequestType;
use Modules\MNT\Enums\MaintenanceStage;
use Modules\MNT\Services\MaintenanceRequestService;

class MaintenanceRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('mnt::forms.maintenance_request.section_details'))
                    ->schema([
                        TextInput::make('reference')
                            ->default(fn () => MaintenanceRequestService::generateReference())
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),

                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Select::make('equipment_id')
                            ->label(__('mnt::forms.maintenance_request.equipment'))
                            ->relationship('equipment', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('category_id')
                            ->label(__('mnt::forms.maintenance_request.category'))
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),

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
                            ->required()
                            ->visibleOn('edit'),

                        Select::make('team_id')
                            ->label(__('mnt::forms.maintenance_request.maintenance_team'))
                            ->relationship('team', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('technician_id')
                            ->label(__('mnt::forms.maintenance_request.technician'))
                            ->relationship('technician', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('requested_by')
                            ->label(__('mnt::forms.maintenance_request.requested_by'))
                            ->relationship('requestedBy', 'name')
                            ->searchable()
                            ->preload()
                            ->default(fn () => auth()->id()),

                        DatePicker::make('scheduled_date'),

                        TextInput::make('duration')
                            ->label(__('mnt::forms.maintenance_request.duration_hours'))
                            ->numeric()
                            ->minValue(0)
                            ->visibleOn('edit'),
                    ])
                    ->columns(2),

                Section::make(__('mnt::forms.maintenance_request.section_description'))
                    ->schema([
                        Textarea::make('description')
                            ->rows(4)
                            ->columnSpanFull(),

                        Textarea::make('notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
