<?php

namespace Modules\MNT\Filament\Resources\PreventiveSchedules;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\MNT\Filament\Resources\PreventiveSchedules\Pages\CreatePreventiveSchedule;
use Modules\MNT\Filament\Resources\PreventiveSchedules\Pages\EditPreventiveSchedule;
use Modules\MNT\Filament\Resources\PreventiveSchedules\Pages\ListPreventiveSchedules;
use Modules\MNT\Filament\Resources\PreventiveSchedules\Schemas\PreventiveScheduleForm;
use Modules\MNT\Filament\Resources\PreventiveSchedules\Tables\PreventiveSchedulesTable;
use Modules\MNT\Models\MntPreventiveSchedule;

class PreventiveScheduleResource extends Resource
{
    protected static ?string $model = MntPreventiveSchedule::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('mnt::resources.preventive_schedule.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('mnt::resources.preventive_schedule.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('mnt::resources.preventive_schedule.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('mnt::resources.preventive_schedule.navigation_group');
    }

    public static function form(Schema $schema): Schema
    {
        return PreventiveScheduleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PreventiveSchedulesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPreventiveSchedules::route('/'),
            'create' => CreatePreventiveSchedule::route('/create'),
            'edit' => EditPreventiveSchedule::route('/{record}/edit'),
        ];
    }
}
