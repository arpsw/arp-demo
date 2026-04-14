<?php

namespace Modules\SFD\Filament\Resources\WorkOrders\Tables;

use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Modules\SFD\Enums\WorkOrderStatus;
use Modules\SFD\Models\SfdWorkOrder;
use Modules\SFD\Services\WorkOrderService;

class WorkOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('manufacturingOrder.reference')
                    ->label(__('sfd::tables.columns.mo'))
                    ->searchable()
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
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(WorkOrderStatus::class)
                    ->multiple(),
                SelectFilter::make('work_center_id')
                    ->relationship('workCenter', 'name')
                    ->label(__('sfd::forms.fields.work_center'))
                    ->preload(),
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

                ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading(__('sfd::tables.empty_state.work_orders'))
            ->emptyStateIcon(Heroicon::OutlinedWrenchScrewdriver);
    }
}
