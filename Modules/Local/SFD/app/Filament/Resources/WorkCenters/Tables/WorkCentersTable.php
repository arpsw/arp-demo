<?php

namespace Modules\SFD\Filament\Resources\WorkCenters\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WorkCentersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('capacity')
                    ->sortable(),

                TextColumn::make('cost_per_hour')
                    ->money('EUR')
                    ->sortable(),

                TextColumn::make('time_before_production')
                    ->suffix(' min')
                    ->label(__('sfd::tables.columns.setup')),

                TextColumn::make('time_after_production')
                    ->suffix(' min')
                    ->label(__('sfd::tables.columns.teardown')),

                TextColumn::make('equipment_count')
                    ->counts('equipment')
                    ->label(__('sfd::tables.columns.equipment'))
                    ->badge()
                    ->color('info'),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label(__('sfd::tables.columns.active')),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order')
            ->emptyStateHeading(__('sfd::tables.empty_state.work_centers'))
            ->emptyStateIcon(Heroicon::OutlinedBuildingOffice);
    }
}
