<?php

namespace Modules\SFD\Filament\Resources\BillOfMaterials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BillOfMaterialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('product.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('product.type')
                    ->badge()
                    ->label(__('sfd::tables.columns.product_type')),

                TextColumn::make('quantity')
                    ->sortable(),

                TextColumn::make('components_count')
                    ->counts('components')
                    ->label(__('sfd::tables.columns.components'))
                    ->badge()
                    ->color('info'),

                TextColumn::make('operations_count')
                    ->counts('operations')
                    ->label(__('sfd::tables.columns.operations'))
                    ->badge()
                    ->color('warning'),

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
            ->defaultSort('name')
            ->emptyStateHeading(__('sfd::tables.empty_state.bill_of_materials'))
            ->emptyStateIcon(Heroicon::OutlinedClipboardDocumentList);
    }
}
