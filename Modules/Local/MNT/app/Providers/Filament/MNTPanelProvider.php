<?php

namespace Modules\MNT\Providers\Filament;

use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Icons\Heroicon;
use Modules\Core\Filament\Contracts\HasPanelSwitchIcon;
use Modules\Core\Filament\Traits\SharedPanelConfiguration;

class MNTPanelProvider extends PanelProvider implements HasPanelSwitchIcon
{
    use SharedPanelConfiguration;

    protected string $moduleName = 'MNT';

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('mnt')
            ->path('mnt')
            ->discoverResources(in: $this->modulePath('app/Filament/Resources'), for: 'Modules\MNT\Filament\Resources')
            ->discoverPages(in: $this->modulePath('app/Filament/Pages'), for: 'Modules\MNT\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: $this->modulePath('app/Filament/Widgets'), for: 'Modules\MNT\Filament\Widgets')
            ->widgets([]);
    }

    public function panelId(): string
    {
        return 'mnt';
    }

    public function panelSwitchIcon(): Heroicon
    {
        return Heroicon::OutlinedWrench;
    }
}
