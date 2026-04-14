<?php

namespace Modules\SFD\Filament\Resources\WorkCenters\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WorkCenterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('sfd::forms.sections.work_center_details'))
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),

                        TextInput::make('capacity')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required(),

                        TextInput::make('cost_per_hour')
                            ->numeric()
                            ->prefix('€')
                            ->step(0.01)
                            ->default(0),

                        TextInput::make('time_before_production')
                            ->numeric()
                            ->suffix('min')
                            ->default(0)
                            ->label(__('sfd::forms.fields.setup_time')),

                        TextInput::make('time_after_production')
                            ->numeric()
                            ->suffix('min')
                            ->default(0)
                            ->label(__('sfd::forms.fields.teardown_time')),

                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_active')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
