<?php

namespace Modules\MNT\Filament\Resources\MaintenanceRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Modules\MNT\Enums\MaintenancePriority;
use Modules\MNT\Enums\MaintenanceRequestType;
use Modules\MNT\Enums\MaintenanceStage;

class MaintenanceRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('equipment.name')
                    ->label(__('mnt::tables.maintenance_request.equipment'))
                    ->sortable()
                    ->placeholder(__('mnt::tables.placeholders.dash')),

                TextColumn::make('request_type')
                    ->badge()
                    ->sortable(),

                TextColumn::make('priority')
                    ->badge()
                    ->sortable(),

                TextColumn::make('stage')
                    ->badge()
                    ->sortable(),

                TextColumn::make('team.name')
                    ->label(__('mnt::tables.maintenance_request.team'))
                    ->placeholder(__('mnt::tables.placeholders.dash'))
                    ->toggleable(),

                TextColumn::make('technician.name')
                    ->label(__('mnt::tables.maintenance_request.technician'))
                    ->placeholder(__('mnt::tables.placeholders.dash'))
                    ->toggleable(),

                TextColumn::make('scheduled_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('close_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('request_type')
                    ->options(MaintenanceRequestType::class),
                SelectFilter::make('stage')
                    ->options(MaintenanceStage::class)
                    ->multiple(),
                SelectFilter::make('priority')
                    ->options(MaintenancePriority::class),
                SelectFilter::make('team_id')
                    ->label(__('mnt::tables.maintenance_request.filter_team'))
                    ->relationship('team', 'name'),
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
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading(__('mnt::tables.maintenance_request.empty_heading'))
            ->emptyStateIcon(Heroicon::OutlinedClipboardDocumentList);
    }
}
