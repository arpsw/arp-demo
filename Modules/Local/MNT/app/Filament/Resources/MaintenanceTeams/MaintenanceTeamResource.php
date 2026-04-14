<?php

namespace Modules\MNT\Filament\Resources\MaintenanceTeams;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\MNT\Filament\Resources\MaintenanceTeams\Pages\CreateMaintenanceTeam;
use Modules\MNT\Filament\Resources\MaintenanceTeams\Pages\EditMaintenanceTeam;
use Modules\MNT\Filament\Resources\MaintenanceTeams\Pages\ListMaintenanceTeams;
use Modules\MNT\Filament\Resources\MaintenanceTeams\Schemas\MaintenanceTeamForm;
use Modules\MNT\Filament\Resources\MaintenanceTeams\Tables\MaintenanceTeamsTable;
use Modules\MNT\Models\MntMaintenanceTeam;

class MaintenanceTeamResource extends Resource
{
    protected static ?string $model = MntMaintenanceTeam::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 11;

    public static function getModelLabel(): string
    {
        return __('mnt::resources.maintenance_team.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('mnt::resources.maintenance_team.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('mnt::resources.maintenance_team.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('mnt::resources.maintenance_team.navigation_group');
    }

    public static function form(Schema $schema): Schema
    {
        return MaintenanceTeamForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaintenanceTeamsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMaintenanceTeams::route('/'),
            'create' => CreateMaintenanceTeam::route('/create'),
            'edit' => EditMaintenanceTeam::route('/{record}/edit'),
        ];
    }
}
