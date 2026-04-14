<?php

namespace Modules\MNT\Filament\Resources\Equipment\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Modules\MNT\Enums\EquipmentStatus;

class EquipmentTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('serial_number')
                    ->searchable()
                    ->placeholder(__('mnt::tables.placeholders.dash')),

                TextColumn::make('category.name')
                    ->label(__('mnt::tables.equipment.category'))
                    ->sortable()
                    ->placeholder(__('mnt::tables.placeholders.dash')),

                TextColumn::make('workCenter.name')
                    ->label(__('mnt::tables.equipment.work_center'))
                    ->sortable()
                    ->placeholder(__('mnt::tables.placeholders.dash')),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('manufacturer')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('location')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('maintenance_requests_count')
                    ->counts('maintenanceRequests')
                    ->label(__('mnt::tables.equipment.requests'))
                    ->badge()
                    ->color('info'),

                TextColumn::make('next_preventive_date')
                    ->date()
                    ->label(__('mnt::tables.equipment.next_pm'))
                    ->sortable()
                    ->placeholder(__('mnt::tables.placeholders.dash')),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(EquipmentStatus::class)
                    ->multiple(),
                SelectFilter::make('category_id')
                    ->label(__('mnt::tables.equipment.filter_category'))
                    ->relationship('category', 'name'),
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
            ->defaultSort('name')
            ->emptyStateHeading(__('mnt::tables.equipment.empty_heading'))
            ->emptyStateIcon(Heroicon::OutlinedWrenchScrewdriver);
    }
}
