<?php

namespace Modules\MNT\Enums;

use BackedEnum;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum MaintenanceStage: string implements HasColor, HasIcon, HasLabel
{
    case New = 'new';
    case InProgress = 'in_progress';
    case Repaired = 'repaired';
    case Scrap = 'scrap';

    public function getLabel(): string
    {
        return match ($this) {
            self::New => __('mnt::enums.maintenance_stage.new'),
            self::InProgress => __('mnt::enums.maintenance_stage.in_progress'),
            self::Repaired => __('mnt::enums.maintenance_stage.repaired'),
            self::Scrap => __('mnt::enums.maintenance_stage.scrap'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::New => Color::Gray,
            self::InProgress => Color::Orange,
            self::Repaired => Color::Green,
            self::Scrap => Color::Red,
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::New => Heroicon::OutlinedSparkles,
            self::InProgress => Heroicon::ArrowPath,
            self::Repaired => Heroicon::CheckBadge,
            self::Scrap => Heroicon::Trash,
        };
    }
}
