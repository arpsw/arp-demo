<?php

declare(strict_types=1);

namespace App\Providers;

use App\Filament\MainPanelConfigurator;
use App\Support\FilamentBroadcasting;
use Illuminate\Support\ServiceProvider;
use Modules\Ai\Filament\Contracts\PanelConfigurator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PanelConfigurator::class, MainPanelConfigurator::class);

        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    public function boot(): void
    {
        FilamentBroadcasting::configureEcho();
    }
}
