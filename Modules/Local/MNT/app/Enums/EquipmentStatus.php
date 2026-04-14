<?php

namespace Modules\MNT\Enums;

use BackedEnum;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum EquipmentStatus: string implements HasColor, HasIcon, HasLabel
{
    case Operational = 'operational';
    case Maintenance = 'maintenance';
    case OutOfService = 'out_of_service';
    case Retired = 'retired';

    public function getLabel(): string
    {
        return match ($this) {
            self::Operational => __('mnt::enums.equipment_status.operational'),
            self::Maintenance => __('mnt::enums.equipment_status.maintenance'),
            self::OutOfService => __('mnt::enums.equipment_status.out_of_service'),
            self::Retired => __('mnt::enums.equipment_status.retired'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Operational => Color::Green,
            self::Maintenance => Color::Orange,
            self::OutOfService => Color::Red,
            self::Retired => Color::Gray,
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::Operational => Heroicon::CheckCircle,
            self::Maintenance => Heroicon::Wrench,
            self::OutOfService => Heroicon::ExclamationTriangle,
            self::Retired => Heroicon::ArchiveBox,
        };
    }
}
