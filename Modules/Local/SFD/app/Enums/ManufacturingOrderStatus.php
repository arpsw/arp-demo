<?php

namespace Modules\SFD\Enums;

use BackedEnum;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum ManufacturingOrderStatus: string implements HasColor, HasIcon, HasLabel
{
    case Draft = 'draft';
    case Confirmed = 'confirmed';
    case InProgress = 'in_progress';
    case Done = 'done';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return __('sfd::enums.manufacturing_order_status.'.$this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => Color::Gray,
            self::Confirmed => Color::Blue,
            self::InProgress => Color::Orange,
            self::Done => Color::Green,
            self::Cancelled => Color::Red,
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::Draft => Heroicon::PencilSquare,
            self::Confirmed => Heroicon::CheckCircle,
            self::InProgress => Heroicon::ArrowPath,
            self::Done => Heroicon::CheckBadge,
            self::Cancelled => Heroicon::XCircle,
        };
    }
}
