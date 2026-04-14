<?php

namespace Modules\MNT\Enums;

use BackedEnum;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum MaintenancePriority: string implements HasColor, HasIcon, HasLabel
{
    case Low = 'low';
    case Normal = 'normal';
    case High = 'high';
    case Urgent = 'urgent';

    public function getLabel(): string
    {
        return match ($this) {
            self::Low => __('mnt::enums.maintenance_priority.low'),
            self::Normal => __('mnt::enums.maintenance_priority.normal'),
            self::High => __('mnt::enums.maintenance_priority.high'),
            self::Urgent => __('mnt::enums.maintenance_priority.urgent'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Low => Color::Gray,
            self::Normal => Color::Blue,
            self::High => Color::Orange,
            self::Urgent => Color::Red,
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::Low => Heroicon::ArrowDown,
            self::Normal => Heroicon::Minus,
            self::High => Heroicon::ArrowUp,
            self::Urgent => Heroicon::Fire,
        };
    }
}
