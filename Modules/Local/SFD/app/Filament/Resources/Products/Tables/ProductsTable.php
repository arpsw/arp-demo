<?php

namespace Modules\SFD\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Modules\SFD\Enums\ProductType;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sku')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->badge()
                    ->sortable(),

                TextColumn::make('unit_cost')
                    ->money('EUR')
                    ->sortable(),

                TextColumn::make('bill_of_materials_count')
                    ->counts('billOfMaterials')
                    ->label(__('sfd::tables.columns.boms'))
                    ->badge()
                    ->color('primary'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(ProductType::class),
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
            ->emptyStateHeading(__('sfd::tables.empty_state.products'))
            ->emptyStateDescription(__('sfd::tables.empty_state.products_description'))
            ->emptyStateIcon(Heroicon::OutlinedCube);
    }
}
