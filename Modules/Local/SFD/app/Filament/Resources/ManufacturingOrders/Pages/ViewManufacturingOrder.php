<?php

namespace Modules\SFD\Filament\Resources\ManufacturingOrders\Pages;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Modules\SFD\Enums\ManufacturingOrderStatus;
use Modules\SFD\Filament\Resources\ManufacturingOrders\ManufacturingOrderResource;
use Modules\SFD\Services\ManufacturingOrderService;

class ViewManufacturingOrder extends ViewRecord
{
    protected static string $resource = ManufacturingOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('confirm')
                ->label(__('sfd::pages.manufacturing_orders.confirm_action'))
                ->icon(Heroicon::CheckCircle)
                ->color('success')
                ->visible(fn () => $this->record->status === ManufacturingOrderStatus::Draft)
                ->requiresConfirmation()
                ->modalDescription(__('sfd::pages.manufacturing_orders.confirm_modal_description'))
                ->action(function (ManufacturingOrderService $service) {
                    $service->confirm($this->record);

                    Notification::make()
                        ->title(__('sfd::pages.manufacturing_orders.confirmed_title'))
                        ->body(__('sfd::pages.manufacturing_orders.confirmed_body'))
                        ->success()
                        ->send();

                    $this->refreshFormData(['status']);
                }),

            Action::make('complete')
                ->label(__('sfd::pages.manufacturing_orders.complete_action'))
                ->icon(Heroicon::CheckBadge)
                ->color('success')
                ->visible(fn () => in_array($this->record->status, [
                    ManufacturingOrderStatus::Confirmed,
                    ManufacturingOrderStatus::InProgress,
                ]))
                ->requiresConfirmation()
                ->action(function (ManufacturingOrderService $service) {
                    $service->complete($this->record);

                    Notification::make()
                        ->title(__('sfd::pages.manufacturing_orders.completed_title'))
                        ->success()
                        ->send();

                    $this->refreshFormData(['status', 'completed_at']);
                }),

            Action::make('cancel')
                ->label(__('sfd::pages.manufacturing_orders.cancel_action'))
                ->icon(Heroicon::XCircle)
                ->color('danger')
                ->visible(fn () => ! in_array($this->record->status, [
                    ManufacturingOrderStatus::Done,
                    ManufacturingOrderStatus::Cancelled,
                ]))
                ->requiresConfirmation()
                ->action(function (ManufacturingOrderService $service) {
                    $service->cancel($this->record);

                    Notification::make()
                        ->title(__('sfd::pages.manufacturing_orders.cancelled_title'))
                        ->warning()
                        ->send();

                    $this->refreshFormData(['status']);
                }),

            EditAction::make(),
        ];
    }
}
