<?php

namespace Modules\SFD\Filament\Resources\WorkCenters\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class EquipmentRelationManager extends RelationManager
{
    protected static string $relationship = 'equipment';

    protected static ?string $title = null;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('sfd::pages.relation_managers.equipment');
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('serial_number')
                    ->searchable()
                    ->placeholder(__('sfd::tables.placeholders.dash')),

                TextColumn::make('category.name')
                    ->label(__('sfd::tables.columns.category'))
                    ->badge()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('manufacturer')
                    ->placeholder(__('sfd::tables.placeholders.dash'))
                    ->toggleable(),

                TextColumn::make('model')
                    ->placeholder(__('sfd::tables.placeholders.dash'))
                    ->toggleable(),

                TextColumn::make('location')
                    ->placeholder(__('sfd::tables.placeholders.dash'))
                    ->toggleable(),
            ])
            ->defaultSort('name');
    }
}
