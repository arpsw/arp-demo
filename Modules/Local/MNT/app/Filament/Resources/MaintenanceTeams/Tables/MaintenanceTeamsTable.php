<?php

namespace Modules\MNT\Filament\Resources\MaintenanceTeams\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MaintenanceTeamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                ColorColumn::make('color'),

                TextColumn::make('company')
                    ->searchable()
                    ->placeholder(__('mnt::tables.placeholders.dash')),

                TextColumn::make('members_count')
                    ->counts('members')
                    ->label(__('mnt::tables.maintenance_team.members_count'))
                    ->badge()
                    ->color('info'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name')
            ->emptyStateHeading(__('mnt::tables.maintenance_team.empty_heading'))
            ->emptyStateIcon(Heroicon::OutlinedUserGroup);
    }
}
