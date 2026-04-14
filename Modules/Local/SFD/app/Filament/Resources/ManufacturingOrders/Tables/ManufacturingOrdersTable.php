<?php

namespace Modules\SFD\Filament\Resources\ManufacturingOrders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Modules\SFD\Enums\ManufacturingOrderPriority;
use Modules\SFD\Enums\ManufacturingOrderStatus;

class ManufacturingOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('product.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('quantity')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('priority')
                    ->badge()
                    ->sortable(),

                TextColumn::make('work_orders_count')
                    ->counts('workOrders')
                    ->label(__('sfd::tables.columns.work_orders'))
                    ->badge()
                    ->color('info'),

                TextColumn::make('scheduled_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('deadline')
                    ->date()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(ManufacturingOrderStatus::class)
                    ->multiple(),
                SelectFilter::make('priority')
                    ->options(ManufacturingOrderPriority::class),
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
            ->emptyStateHeading(__('sfd::tables.empty_state.manufacturing_orders'))
            ->emptyStateIcon(Heroicon::OutlinedClipboardDocumentCheck);
    }
}
