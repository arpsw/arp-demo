<?php

namespace Modules\MNT\Filament\Resources\MaintenanceRequests\Pages;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Modules\MNT\Enums\MaintenanceStage;
use Modules\MNT\Filament\Resources\MaintenanceRequests\MaintenanceRequestResource;
use Modules\MNT\Services\MaintenanceRequestService;

class ViewMaintenanceRequest extends ViewRecord
{
    protected static string $resource = MaintenanceRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('start')
                ->label(__('mnt::pages.maintenance_request.start_work'))
                ->icon(Heroicon::Play)
                ->color('warning')
                ->visible(fn () => $this->record->stage === MaintenanceStage::New)
                ->requiresConfirmation()
                ->action(function (MaintenanceRequestService $service) {
                    $service->start($this->record);

                    Notification::make()
                        ->title(__('mnt::pages.maintenance_request.notification_started'))
                        ->success()
                        ->send();

                    $this->refreshFormData(['stage']);
                }),

            Action::make('complete')
                ->label(__('mnt::pages.maintenance_request.mark_as_repaired'))
                ->icon(Heroicon::CheckBadge)
                ->color('success')
                ->visible(fn () => $this->record->stage === MaintenanceStage::InProgress)
                ->requiresConfirmation()
                ->action(function (MaintenanceRequestService $service) {
                    $service->complete($this->record);

                    Notification::make()
                        ->title(__('mnt::pages.maintenance_request.notification_repaired'))
                        ->success()
                        ->send();

                    $this->refreshFormData(['stage', 'close_date']);
                }),

            Action::make('scrap')
                ->label(__('mnt::pages.maintenance_request.scrap'))
                ->icon(Heroicon::Trash)
                ->color('danger')
                ->visible(fn () => in_array($this->record->stage, [
                    MaintenanceStage::New,
                    MaintenanceStage::InProgress,
                ]))
                ->requiresConfirmation()
                ->modalDescription(__('mnt::pages.maintenance_request.scrap_modal_description'))
                ->action(function (MaintenanceRequestService $service) {
                    $service->scrap($this->record);

                    Notification::make()
                        ->title(__('mnt::pages.maintenance_request.notification_scrapped'))
                        ->warning()
                        ->send();

                    $this->refreshFormData(['stage', 'close_date']);
                }),

            EditAction::make(),
        ];
    }
}
