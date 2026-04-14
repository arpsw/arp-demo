<?php

namespace Modules\MNT\Enums;

use BackedEnum;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum MaintenanceRequestType: string implements HasColor, HasIcon, HasLabel
{
    case Corrective = 'corrective';
    case Preventive = 'preventive';

    public function getLabel(): string
    {
        return match ($this) {
            self::Corrective => __('mnt::enums.maintenance_request_type.corrective'),
            self::Preventive => __('mnt::enums.maintenance_request_type.preventive'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Corrective => Color::Red,
            self::Preventive => Color::Blue,
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::Corrective => Heroicon::WrenchScrewdriver,
            self::Preventive => Heroicon::ShieldCheck,
        };
    }
}
