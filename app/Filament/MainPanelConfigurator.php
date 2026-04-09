<?php

declare(strict_types=1);

namespace App\Filament;

use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Modules\Ai\Filament\Contracts\PanelConfigurator;

class MainPanelConfigurator implements PanelConfigurator
{
    public function configurePanel(Panel $panel): Panel
    {
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch): void {
            $switch
                ->circular()
                ->locales(['en', 'de', 'nl', 'ar', 'sl', 'hr']);
        });

        $panel->colors([
            'primary' => Color::Emerald,
        ]);

        return $panel
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
