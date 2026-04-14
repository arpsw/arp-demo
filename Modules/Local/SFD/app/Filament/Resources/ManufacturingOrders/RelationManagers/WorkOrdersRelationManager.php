<?php

namespace Modules\SFD\Filament\Resources\ManufacturingOrders\RelationManagers;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\SFD\Enums\WorkOrderStatus;
use Modules\SFD\Models\SfdWorkOrder;
use Modules\SFD\Services\WorkOrderService;

class WorkOrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'workOrders';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')
                    ->label(__('sfd::tables.columns.sequence'))
                    ->sortable(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('workCenter.name')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('expected_duration')
                    ->suffix(' min')
                    ->label(__('sfd::tables.columns.expected')),

                TextColumn::make('actual_duration')
                    ->suffix(' min')
                    ->label(__('sfd::tables.columns.actual'))
                    ->placeholder(__('sfd::tables.placeholders.dash')),

                TextColumn::make('assignedUser.name')
                    ->label(__('sfd::tables.columns.operator'))
                    ->placeholder(__('sfd::tables.placeholders.unassigned')),

                TextColumn::make('started_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('completed_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                Action::make('start')
                    ->icon(Heroicon::Play)
                    ->color('success')
                    ->visible(fn (SfdWorkOrder $record) => in_array($record->status, [
                        WorkOrderStatus::Pending,
                        WorkOrderStatus::Ready,
                    ]))
                    ->action(function (SfdWorkOrder $record, WorkOrderService $service) {
                        $service->start($record);
                        Notification::make()->title(__('sfd::pages.work_orders.started_title'))->success()->send();
                    }),

                Action::make('complete')
                    ->icon(Heroicon::Check)
                    ->color('success')
                    ->visible(fn (SfdWorkOrder $record) => $record->status === WorkOrderStatus::InProgress)
                    ->action(function (SfdWorkOrder $record, WorkOrderService $service) {
                        $service->complete($record);
                        Notification::make()->title(__('sfd::pages.work_orders.completed_title'))->success()->send();
                    }),

                Action::make('pause')
                    ->icon(Heroicon::Pause)
                    ->color('warning')
                    ->visible(fn (SfdWorkOrder $record) => $record->status === WorkOrderStatus::InProgress)
                    ->action(function (SfdWorkOrder $record, WorkOrderService $service) {
                        $service->pause($record);
                        Notification::make()->title(__('sfd::pages.work_orders.paused_title'))->info()->send();
                    }),
            ])
            ->defaultSort('sort_order');
    }
}
