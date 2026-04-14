<?php

namespace Modules\MNT\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Icons\Heroicon;
use Modules\Core\Filament\Contracts\HasPanelSwitchIcon;
use Modules\Core\Filament\Traits\SharedPanelConfiguration;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class MNTPanelProvider extends PanelProvider implements HasPanelSwitchIcon
{
    use SharedPanelConfiguration;

    public function panel(Panel $panel): Panel
    {
        $panel = $panel
            ->id('mnt')
            ->path('mnt');

        $panel = $this->applySharedConfiguration($panel);

        return $panel
            ->discoverResources(in: module_path('MNT', '/app/Filament/Resources'), for: 'Modules\MNT\Filament\Resources')
            ->discoverPages(in: module_path('MNT', '/app/Filament/Pages'), for: 'Modules\MNT\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: module_path('MNT', '/app/Filament/Widgets'), for: 'Modules\MNT\Filament\Widgets')
            ->widgets([])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
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
