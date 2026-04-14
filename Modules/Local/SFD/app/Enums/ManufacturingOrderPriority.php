<?php

namespace Modules\SFD\Enums;

use BackedEnum;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum ManufacturingOrderPriority: string implements HasColor, HasIcon, HasLabel
{
    case Low = 'low';
    case Normal = 'normal';
    case High = 'high';
    case Urgent = 'urgent';

    public function getLabel(): string
    {
        return __('sfd::enums.manufacturing_order_priority.'.$this->value);
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
            self::Low => Heroicon::ChevronDown,
            self::Normal => Heroicon::Minus,
            self::High => Heroicon::ChevronUp,
            self::Urgent => Heroicon::ExclamationTriangle,
        };
    }
}
