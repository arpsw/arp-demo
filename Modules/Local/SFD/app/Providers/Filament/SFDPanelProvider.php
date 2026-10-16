<?php

namespace Modules\SFD\Providers\Filament;

use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Icons\Heroicon;
use Modules\Core\Filament\Contracts\HasPanelSwitchIcon;
use Modules\Core\Filament\Traits\SharedPanelConfiguration;

class SFDPanelProvider extends PanelProvider implements HasPanelSwitchIcon
{
    use SharedPanelConfiguration;

    protected string $moduleName = 'SFD';

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('sfd')
            ->path('sfd')
            ->discoverResources(in: $this->modulePath('app/Filament/Resources'), for: 'Modules\SFD\Filament\Resources')
            ->discoverPages(in: $this->modulePath('app/Filament/Pages'), for: 'Modules\SFD\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: $this->modulePath('app/Filament/Widgets'), for: 'Modules\SFD\Filament\Widgets')
            ->widgets([]);
    }

    public function panelId(): string
    {
        return 'sfd';
    }

    public function panelSwitchIcon(): Heroicon
    {
        return Heroicon::OutlinedWrenchScrewdriver;
    }
}
