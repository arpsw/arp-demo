<?php

namespace Modules\MNT\Filament\Resources\MaintenanceTeams\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Modules\MNT\Enums\TeamMemberRole;

class MaintenanceTeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('mnt::forms.maintenance_team.section_details'))
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        ColorPicker::make('color'),

                        TextInput::make('company')
                            ->maxLength(255),

                        Textarea::make('notes')
                            ->columnSpanFull()
                            ->rows(3),
                    ])
                    ->columnSpanFull()
                    ->columns(2),

                Section::make(__('mnt::forms.maintenance_team.section_members'))
                    ->schema([
                        Repeater::make('members')
                            ->relationship()
                            ->schema([
                                TextInput::make('first_name')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('last_name')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('phone')
                                    ->tel()
                                    ->placeholder('+38631614683')
                                    ->regex('/^\+[1-9]\d{6,14}$/')
                                    ->maxLength(20),

                                Select::make('role')
                                    ->options(TeamMemberRole::class)
                                    ->default(TeamMemberRole::Member)
                                    ->required(),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->reorderable(false)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
