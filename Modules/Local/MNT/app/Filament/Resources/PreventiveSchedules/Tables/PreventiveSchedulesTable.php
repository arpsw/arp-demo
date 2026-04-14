<?php

namespace Modules\MNT\Filament\Resources\PreventiveSchedules\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Modules\MNT\Models\MntPreventiveSchedule;
use Modules\MNT\Services\PreventiveMaintenanceService;

class PreventiveSchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('equipment.name')
                    ->label(__('mnt::tables.preventive_schedule.equipment'))
                    ->sortable(),

                TextColumn::make('frequency_days')
                    ->label(__('mnt::tables.preventive_schedule.every_days'))
                    ->sortable(),

                TextColumn::make('priority')
                    ->badge()
                    ->sortable(),

                TextColumn::make('team.name')
                    ->label(__('mnt::tables.preventive_schedule.team'))
                    ->placeholder(__('mnt::tables.placeholders.dash')),

                TextColumn::make('next_date')
                    ->date()
                    ->label(__('mnt::tables.preventive_schedule.next_date'))
                    ->sortable(),

                TextColumn::make('last_generated_date')
                    ->date()
                    ->label(__('mnt::tables.preventive_schedule.last_generated'))
                    ->placeholder(__('mnt::tables.placeholders.never'))
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('mnt::tables.preventive_schedule.filter_active')),
            ])
            ->recordActions([
                Action::make('generate')
                    ->label(__('mnt::tables.preventive_schedule.generate_request'))
                    ->icon(Heroicon::Plus)
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (MntPreventiveSchedule $record, PreventiveMaintenanceService $service) {
                        $service->generateRequest($record);

                        Notification::make()
                            ->title(__('mnt::pages.maintenance_request.notification_request_generated'))
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('next_date')
            ->emptyStateHeading(__('mnt::tables.preventive_schedule.empty_heading'))
            ->emptyStateIcon(Heroicon::OutlinedCalendarDays);
    }
}
