<?php

namespace Modules\SFD\Filament\Resources\WorkOrders\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Modules\SFD\Enums\WorkOrderStatus;
use Modules\SFD\Filament\Resources\WorkOrders\WorkOrderResource;
use Modules\SFD\Services\WorkOrderService;

class ViewWorkOrder extends ViewRecord
{
    protected static string $resource = WorkOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('start')
                ->label(__('sfd::pages.work_orders.start_action'))
                ->icon(Heroicon::Play)
                ->color('success')
                ->visible(fn () => in_array($this->record->status, [
                    WorkOrderStatus::Pending,
                    WorkOrderStatus::Ready,
                ]))
                ->action(function (WorkOrderService $service) {
                    $service->start($this->record);
                    Notification::make()->title(__('sfd::pages.work_orders.started_title'))->success()->send();
                    $this->refreshFormData(['status', 'started_at', 'assigned_to']);
                }),

            Action::make('complete')
                ->label(__('sfd::pages.work_orders.complete_action'))
                ->icon(Heroicon::CheckCircle)
                ->color('success')
                ->visible(fn () => $this->record->status === WorkOrderStatus::InProgress)
                ->action(function (WorkOrderService $service) {
                    $service->complete($this->record);
                    Notification::make()->title(__('sfd::pages.work_orders.completed_title'))->success()->send();
                    $this->refreshFormData(['status', 'completed_at', 'actual_duration']);
                }),

            Action::make('pause')
                ->label(__('sfd::pages.work_orders.pause_action'))
                ->icon(Heroicon::Pause)
                ->color('warning')
                ->visible(fn () => $this->record->status === WorkOrderStatus::InProgress)
                ->action(function (WorkOrderService $service) {
                    $service->pause($this->record);
                    Notification::make()->title(__('sfd::pages.work_orders.paused_title'))->info()->send();
                    $this->refreshFormData(['status']);
                }),

            Action::make('malfunction')
                ->label(__('sfd::pages.work_orders.malfunction_action'))
                ->icon(Heroicon::ExclamationTriangle)
                ->color('danger')
                ->visible(fn () => $this->record->status === WorkOrderStatus::InProgress)
                ->modalDescription(__('sfd::pages.work_orders.malfunction_modal_description'))
                ->schema([
                    Textarea::make('description')
                        ->label(__('sfd::pages.work_orders.malfunction_description_label'))
                        ->placeholder(__('sfd::pages.work_orders.malfunction_description_placeholder'))
                        ->required()
                        ->rows(4),
                ])
                ->action(function (array $data, WorkOrderService $service) {
                    $service->malfunction($this->record, $data['description']);
                    Notification::make()
                        ->title(__('sfd::pages.work_orders.malfunction_title'))
                        ->body(__('sfd::pages.work_orders.malfunction_body'))
                        ->danger()
                        ->send();
                    $this->refreshFormData(['status', 'notes']);
                }),
        ];
    }
}
